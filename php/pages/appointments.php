<?php
session_start();
// Require login
if (empty($_SESSION['username'])) {
    header('Location: ../authentication/login.php');
    exit;
}

// Include DB connection but suppress its direct output
ob_start();
require_once __DIR__ . '/../../includes/connection.php';
ob_end_clean();

$errors = [];
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $patient_id = $_POST['patient_id'] ?? 0;
        $appointment_date = $_POST['appointment_date'] ?? '';
        $appointment_time = $_POST['appointment_time'] ?? '';
        $appointment_type = trim($_POST['appointment_type'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $status = $_POST['status'] ?? 'Scheduled';
        
        if (empty($patient_id) || empty($appointment_date) || empty($appointment_time)) {
            $errors[] = 'Please fill in all required fields.';
        } else {
            $appointment_datetime = $appointment_date . ' ' . $appointment_time . ':00';
            try {
                $stmt = $conn->prepare("INSERT INTO appointments (patient_id, appointment_date, appointment_type, notes, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                if ($stmt) {
                    $stmt->bind_param("issss", $patient_id, $appointment_datetime, $appointment_type, $notes, $status);
                    if ($stmt->execute()) {
                        $success = 'Appointment scheduled successfully!';
                    } else {
                        $errors[] = 'Failed to schedule appointment.';
                    }
                    $stmt->close();
                }
            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'delete') {
        $appointment_id = $_POST['appointment_id'] ?? 0;
        try {
            $stmt = $conn->prepare("DELETE FROM appointments WHERE appointment_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $appointment_id);
                if ($stmt->execute()) {
                    $success = 'Appointment deleted successfully!';
                }
                $stmt->close();
            }
        } catch (Exception $e) {
            $errors[] = 'Error deleting appointment.';
        }
    } elseif ($action === 'update') {
        $appointment_id = $_POST['appointment_id'] ?? 0;
        $patient_id = $_POST['patient_id'] ?? 0;
        $appointment_date = $_POST['appointment_date'] ?? '';
        $appointment_time = $_POST['appointment_time'] ?? '';
        $appointment_type = trim($_POST['appointment_type'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $status = $_POST['status'] ?? 'Scheduled';
        
        if (empty($patient_id) || empty($appointment_date) || empty($appointment_time)) {
            $errors[] = 'Please fill in all required fields.';
        } else {
            $appointment_datetime = $appointment_date . ' ' . $appointment_time . ':00';
            try {
                $stmt = $conn->prepare("UPDATE appointments SET patient_id = ?, appointment_date = ?, appointment_type = ?, notes = ?, status = ? WHERE appointment_id = ?");
                if ($stmt) {
                    $stmt->bind_param("issssi", $patient_id, $appointment_datetime, $appointment_type, $notes, $status, $appointment_id);
                    if ($stmt->execute()) {
                        $success = 'Appointment updated successfully!';
                    } else {
                        $errors[] = 'Failed to update appointment.';
                    }
                    $stmt->close();
                }
            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'update_status') {
        $appointment_id = $_POST['appointment_id'] ?? 0;
        $status = $_POST['status'] ?? 'Scheduled';
        try {
            $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
            if ($stmt) {
                $stmt->bind_param("si", $status, $appointment_id);
                if ($stmt->execute()) {
                    $success = 'Appointment status updated successfully!';
                }
                $stmt->close();
            }
        } catch (Exception $e) {
            $errors[] = 'Error updating appointment status.';
        }
    }
}

// Fetch patients for dropdown
$patients = [];
try {
    $result = $conn->query("SELECT patient_id, first_name, last_name FROM patients ORDER BY last_name, first_name");
    if ($result) {
        $patients = $result->fetch_all(MYSQLI_ASSOC);
    }
} catch (Exception $e) {
    $patients = [];
}

// Fetch appointments with patient names
$appointments = [];
try {
    $result = $conn->query("
        SELECT a.*, p.first_name, p.last_name, p.phone, p.email 
        FROM appointments a 
        LEFT JOIN patients p ON a.patient_id = p.patient_id 
        ORDER BY a.appointment_date DESC
    ");
    if ($result) {
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
    }
} catch (Exception $e) {
    $appointments = [];
}
?>
<?php $pageTitle = 'Appointments - Medicare Clinic'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../../includes/head.php'; ?>

<body class="bg-gray-100 min-h-screen">
    <!-- Include Sidebar -->
    <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="ml-64">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white shadow-sm border-b border-gray-200 px-6 py-5">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Appointments Management</h2>
                <form action="../authentication/logout.php" method="POST" class="inline-block">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <!-- Messages -->
            <?php if (!empty($errors)): ?>
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <?php foreach ($errors as $error): ?>
                        <p><i class="fas fa-exclamation-circle mr-2"></i><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <p><i class="fas fa-check-circle mr-2"></i><?php echo htmlspecialchars($success); ?></p>
                </div>
            <?php endif; ?>

            <!-- Schedule Appointment Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-calendar-plus mr-2 text-blue-600"></i>Schedule New Appointment
                </h3>
                <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="hidden" name="action" value="add">
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Patient *</label>
                        <select name="patient_id" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select Patient</option>
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?php echo htmlspecialchars($patient['patient_id']); ?>">
                                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($patients)): ?>
                            <p class="text-xs text-gray-500 mt-1">
                                <a href="patients.php" class="text-blue-600 hover:underline">Add patients first</a>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Date *</label>
                        <input type="date" name="appointment_date" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Time *</label>
                        <input type="time" name="appointment_time" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Type</label>
                        <select name="appointment_type"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select Type</option>
                            <option value="General Consultation">General Consultation</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Check-up">Check-up</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Lab Test">Lab Test</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Scheduled">Scheduled</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Notes</label>
                        <textarea name="notes" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Additional notes about the appointment..."></textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Schedule Appointment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Appointments Table -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>All Appointments (<span id="appointmentCount"><?php echo count($appointments); ?></span>)
                    </h3>
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text" id="searchAppointments" placeholder="Search appointments..." 
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-64">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <?php if (empty($appointments)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-600 mb-2">No appointments found</p>
                        <p class="text-sm text-gray-500">Schedule a new appointment using the form above</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr class="hover:bg-gray-50 appointment-row" 
                                        data-patient="<?php echo strtolower(htmlspecialchars(($appointment['first_name'] ?? '') . ' ' . ($appointment['last_name'] ?? ''))); ?>" 
                                        data-phone="<?php echo htmlspecialchars($appointment['phone'] ?? ''); ?>" 
                                        data-type="<?php echo strtolower(htmlspecialchars($appointment['appointment_type'] ?? '')); ?>" 
                                        data-status="<?php echo strtolower(htmlspecialchars($appointment['status'] ?? '')); ?>">
                                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo htmlspecialchars($appointment['appointment_id'] ?? ''); ?></td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="font-medium text-gray-900">
                                                <?php echo htmlspecialchars(($appointment['first_name'] ?? '') . ' ' . ($appointment['last_name'] ?? '')); ?>
                                            </div>
                                            <div class="text-xs text-gray-500"><?php echo htmlspecialchars($appointment['phone'] ?? ''); ?></div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            <?php 
                                            if ($appointment['appointment_date']) {
                                                echo date('M d, Y', strtotime($appointment['appointment_date'])) . '<br>';
                                                echo '<span class="text-xs">' . date('h:i A', strtotime($appointment['appointment_date'])) . '</span>';
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo htmlspecialchars($appointment['appointment_type'] ?? 'N/A'); ?></td>
                                        <td class="px-4 py-3 text-sm">
                                            <?php
                                            $status = $appointment['status'] ?? 'Scheduled';
                                            $statusColors = [
                                                'Scheduled' => 'bg-blue-100 text-blue-800',
                                                'Confirmed' => 'bg-green-100 text-green-800',
                                                'Cancelled' => 'bg-red-100 text-red-800',
                                                'Completed' => 'bg-gray-100 text-gray-800'
                                            ];
                                            $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo $colorClass; ?>">
                                                <?php echo htmlspecialchars($status); ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            <?php echo htmlspecialchars(substr($appointment['notes'] ?? '', 0, 50)); ?>
                                            <?php if (strlen($appointment['notes'] ?? '') > 50): ?>...<?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center space-x-2">

                                                <!-- Update Status -->
                                                <form method="POST" action="" class="inline">
                                                    <input type="hidden" name="action" value="update_status">
                                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id'] ?? ''); ?>">
                                                    <select name="status" onchange="this.form.submit()" 
                                                        class="text-xs border rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400">
                                                        <option value="Scheduled" <?php echo ($appointment['status'] ?? '') === 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                                        <option value="Confirmed" <?php echo ($appointment['status'] ?? '') === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                        <option value="Cancelled" <?php echo ($appointment['status'] ?? '') === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                        <option value="Completed" <?php echo ($appointment['status'] ?? '') === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                    </select>
                                                </form>
                                                
                                                <button onclick="openAppointmentViewModal(<?php echo htmlspecialchars(json_encode($appointment), ENT_QUOTES); ?>)" 
                                                    class="text-blue-600 hover:text-blue-800" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button onclick="openAppointmentEditModal(<?php echo htmlspecialchars(json_encode($appointment), ENT_QUOTES); ?>)" 
                                                    class="text-green-600 hover:text-green-800" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <!-- Delete -->
                                                <form method="POST" action="" class="inline" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id'] ?? ''); ?>">
                                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>Appointment Details
                    </h3>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div id="viewModalContent" class="space-y-4">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button onclick="closeViewModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-edit mr-2 text-green-600"></i>Edit Appointment
                    </h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <form method="POST" action="" class="p-6">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="appointment_id" id="edit_appointment_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Patient *</label>
                        <select name="patient_id" id="edit_patient_id" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select Patient</option>
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?php echo htmlspecialchars($patient['patient_id']); ?>">
                                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Date *</label>
                        <input type="date" name="appointment_date" id="edit_appointment_date" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Time *</label>
                        <input type="time" name="appointment_time" id="edit_appointment_time" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Type</label>
                        <select name="appointment_type" id="edit_appointment_type"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select Type</option>
                            <option value="General Consultation">General Consultation</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Check-up">Check-up</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Lab Test">Lab Test</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                        <select name="status" id="edit_status"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Scheduled">Scheduled</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Notes</label>
                        <textarea name="notes" id="edit_notes" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Additional notes about the appointment..."></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-save mr-2"></i>Update Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script src="../includes/app.js"></script>
    <script>
        // Appointment search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchAppointments');
            const tableBody = document.getElementById('appointmentsTableBody');
            const appointmentCount = document.getElementById('appointmentCount');
            
            if (searchInput && tableBody) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = tableBody.querySelectorAll('.appointment-row');
                    let visibleCount = 0;
                    
                    rows.forEach(row => {
                        const patient = row.getAttribute('data-patient') || '';
                        const phone = row.getAttribute('data-phone') || '';
                        const type = row.getAttribute('data-type') || '';
                        const status = row.getAttribute('data-status') || '';
                        
                        if (patient.includes(searchTerm) || phone.includes(searchTerm) || 
                            type.includes(searchTerm) || status.includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Update count
                    if (appointmentCount) {
                        appointmentCount.textContent = visibleCount;
                    }
                });
            }
        });
    </script>

</body>

</html>


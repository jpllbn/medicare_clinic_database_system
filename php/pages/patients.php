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
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $address = trim($_POST['address'] ?? '');
        $gender = $_POST['gender'] ?? '';
        
        if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
            $errors[] = 'Please fill in all required fields.';
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, email, phone, date_of_birth, address, gender, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                if ($stmt) {
                    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone, $date_of_birth, $address, $gender);
                    if ($stmt->execute()) {
                        $success = 'Patient added successfully!';
                    } else {
                        $errors[] = 'Failed to add patient.';
                    }
                    $stmt->close();
                }
            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'update') {
        $patient_id = $_POST['patient_id'] ?? 0;
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $address = trim($_POST['address'] ?? '');
        $gender = $_POST['gender'] ?? '';
        
        if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
            $errors[] = 'Please fill in all required fields.';
        } else {
            try {
                $stmt = $conn->prepare("UPDATE patients SET first_name = ?, last_name = ?, email = ?, phone = ?, date_of_birth = ?, address = ?, gender = ? WHERE patient_id = ?");
                if ($stmt) {
                    $stmt->bind_param("sssssssi", $first_name, $last_name, $email, $phone, $date_of_birth, $address, $gender, $patient_id);
                    if ($stmt->execute()) {
                        $success = 'Patient updated successfully!';
                    } else {
                        $errors[] = 'Failed to update patient.';
                    }
                    $stmt->close();
                }
            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'delete') {
        $patient_id = $_POST['patient_id'] ?? 0;
        try {
            $stmt = $conn->prepare("DELETE FROM patients WHERE patient_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $patient_id);
                if ($stmt->execute()) {
                    $success = 'Patient deleted successfully!';
                }
                $stmt->close();
            }
        } catch (Exception $e) {
            $errors[] = 'Error deleting patient.';
        }
    }
}

// Fetch patients
$patients = [];
try {
    $result = $conn->query("SELECT * FROM patients ORDER BY created_at DESC");
    if ($result) {
        $patients = $result->fetch_all(MYSQLI_ASSOC);
    }
} catch (Exception $e) {
    // Table might not exist yet
    $patients = [];
}
?>
<?php $pageTitle = 'Patients - Medicare Clinic'; ?>
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
                <h2 class="text-xl font-semibold text-gray-800">Patients Management</h2>
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

            <!-- Add Patient Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user-plus mr-2 text-blue-600"></i>Add New Patient
                </h3>
                <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="hidden" name="action" value="add">
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">First Name *</label>
                        <input type="text" name="first_name" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Last Name *</label>
                        <input type="text" name="last_name" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email *</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Phone *</label>
                        <input type="tel" name="phone" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender</label>
                        <select name="gender" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Add Patient
                        </button>
                    </div>
                </form>
            </div>

            <!-- Patients Table -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-users mr-2 text-blue-600"></i>All Patients (<?php echo count($patients); ?>)
                    </h3>
                </div>
                
                <?php if (empty($patients)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-user-slash text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-600 mb-2">No patients found</p>
                        <p class="text-sm text-gray-500">Add a new patient using the form above</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date of Birth</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($patients as $patient): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo htmlspecialchars($patient['patient_id'] ?? ''); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            <?php echo htmlspecialchars(($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? '')); ?>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo htmlspecialchars($patient['email'] ?? ''); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo htmlspecialchars($patient['phone'] ?? ''); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo htmlspecialchars($patient['gender'] ?? 'N/A'); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            <?php echo $patient['date_of_birth'] ? date('M d, Y', strtotime($patient['date_of_birth'])) : 'N/A'; ?>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="openViewModal(<?php echo htmlspecialchars(json_encode($patient), ENT_QUOTES); ?>)" 
                                                    class="text-blue-600 hover:text-blue-800" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($patient), ENT_QUOTES); ?>)" 
                                                    class="text-green-600 hover:text-green-800" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" action="" class="inline" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient['patient_id'] ?? ''); ?>">
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
                        <i class="fas fa-user mr-2 text-blue-600"></i>Patient Details
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
                        <i class="fas fa-edit mr-2 text-green-600"></i>Edit Patient
                    </h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <form method="POST" action="" class="p-6">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="patient_id" id="edit_patient_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">First Name *</label>
                        <input type="text" name="first_name" id="edit_first_name" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Last Name *</label>
                        <input type="text" name="last_name" id="edit_last_name" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email *</label>
                        <input type="email" name="email" id="edit_email" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Phone *</label>
                        <input type="tel" name="phone" id="edit_phone" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="edit_date_of_birth"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender</label>
                        <select name="gender" id="edit_gender" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Address</label>
                        <textarea name="address" id="edit_address" rows="2"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-save mr-2"></i>Update Patient
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script src="../includes/app.js"></script>

</body>

</html>


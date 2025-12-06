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

// Get statistics
$stats = [];
try {
    // Total Patients
    $result = $conn->query("SELECT COUNT(*) as total FROM patients");
    $stats['total_patients'] = $result ? $result->fetch_assoc()['total'] : 0;
    
    // Today's Appointments
    $result = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE DATE(appointment_date) = CURDATE()");
    $stats['today_appointments'] = $result ? $result->fetch_assoc()['total'] : 0;
    
    // Total Appointments
    $result = $conn->query("SELECT COUNT(*) as total FROM appointments");
    $stats['total_appointments'] = $result ? $result->fetch_assoc()['total'] : 0;
    
    // Recent Patients (last 7 days)
    $result = $conn->query("SELECT COUNT(*) as total FROM patients WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
    $stats['recent_patients'] = $result ? $result->fetch_assoc()['total'] : 0;
} catch (Exception $e) {
    // If tables don't exist, set defaults
    $stats = [
        'total_patients' => 0,
        'today_appointments' => 0,
        'total_appointments' => 0,
        'recent_patients' => 0
    ];
}
?>
<?php $pageTitle = 'Dashboard - Medicare Clinic'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../../includes/head.php'; ?>

<body class="bg-gray-100 min-h-screen">
    <!-- Include Sidebar -->
    <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="ml-0 md:ml-64">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white shadow-sm border-b border-gray-200 px-4 md:px-6 py-4 md:py-5">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <!-- Mobile Menu Button -->
                    <button id="openSidebar" class="mobile-menu-btn md:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">Dashboard</h2>
                </div>
                <form action="../authentication/logout.php" method="POST" class="inline-block">
                    <button type="submit" class="bg-red-500 text-white px-3 md:px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm md:text-base">
                        <i class="fas fa-sign-out-alt mr-1 md:mr-2"></i><span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-4 md:p-6">
            <!-- Welcome Section -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome back, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>!</h1>
                <p class="text-gray-600">Here's an overview of your clinic's activity</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Patients Card -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Patients</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $stats['total_patients']; ?></p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments Card -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Today's Appointments</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $stats['today_appointments']; ?></p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Appointments Card -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Appointments</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $stats['total_appointments']; ?></p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-4">
                            <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Recent Patients Card -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">New Patients (7 days)</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $stats['recent_patients']; ?></p>
                        </div>
                        <div class="bg-orange-100 rounded-full p-4">
                            <i class="fas fa-user-plus text-orange-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="patients.php" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <i class="fas fa-user-plus text-blue-600 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-800">Add New Patient</p>
                            <p class="text-sm text-gray-600">Register a new patient</p>
                        </div>
                    </a>
                    <a href="patients.php" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <i class="fas fa-search text-green-600 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-800">View Patients</p>
                            <p class="text-sm text-gray-600">Browse patient records</p>
                        </div>
                    </a>
                    <a href="appointments.php" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                        <i class="fas fa-calendar-plus text-purple-600 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-800">Schedule Appointment</p>
                            <p class="text-sm text-gray-600">Book a new appointment</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-info-circle text-blue-600 mr-4"></i>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">System Ready</p>
                            <p class="text-sm text-gray-600">All systems operational</p>
                        </div>
                        <span class="text-xs text-gray-500"><?php echo date('M d, Y'); ?></span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Custom JavaScript -->
    <script src="../../includes/app.js"></script>
</body>

</html>


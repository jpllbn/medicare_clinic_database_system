<!-- Mobile Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg z-40 md:translate-x-0">
    <div class="flex flex-col h-full">
        <!-- Logo/Brand Section -->
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-blue-600">
                <i class="fas fa-hospital-alt mr-2"></i>Medicare
            </h1>
            <!-- Mobile Close Button -->
            <button id="closeSidebar" class="md:hidden text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="dashboard.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
                        <i class="fas fa-tachometer-alt w-5 mr-3 group-hover:text-blue-600"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Patients -->
                <li>
                    <a href="patients.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
                        <i class="fas fa-users w-5 mr-3 group-hover:text-blue-600"></i>
                        <span class="font-medium">Patients</span>
                    </a>
                </li>

                <!-- Appointments -->
                <li>
                    <a href="appointments.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
                        <i class="fas fa-calendar-alt w-5 mr-3 group-hover:text-blue-600"></i>
                        <span class="font-medium">Appointments</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- User Section -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center px-4 py-3">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-700">
                        <?php echo htmlspecialchars($_SESSION['username'] ?? 'User', ENT_QUOTES); ?>
                    </p>
                    <p class="text-xs text-gray-500">Logged in</p>
                </div>
            </div>
        </div>
    </div>
</aside>


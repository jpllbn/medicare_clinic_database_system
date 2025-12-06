<!-- Header Navigation -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 relative">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="<?php 
                    // Determine correct path to index.php based on where header is included from
                    $currentDir = dirname($_SERVER['PHP_SELF']);
                    if (strpos($currentDir, 'php/authentication') !== false) {
                        echo '../../index.php';
                    } elseif (strpos($currentDir, 'php/pages') !== false) {
                        echo '../../index.php';
                    } else {
                        echo 'index.php';
                    }
                ?>" class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-hospital-alt mr-2"></i>Medicare
                    </h1>
                </a>
            </div>
            
            <!-- Centered Navigation Links -->
            <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center space-x-4">
                <a href="<?php 
                    $currentDir = dirname($_SERVER['PHP_SELF']);
                    if (strpos($currentDir, 'php/authentication') !== false) {
                        echo '../../index.php';
                    } elseif (strpos($currentDir, 'php/pages') !== false) {
                        echo '../../index.php';
                    } else {
                        echo 'index.php';
                    }
                ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="<?php 
                    $currentDir = dirname($_SERVER['PHP_SELF']);
                    if (strpos($currentDir, 'php/authentication') !== false) {
                        echo '../../php/pages/about_us.php';
                    } elseif (strpos($currentDir, 'php/pages') !== false) {
                        echo 'about_us.php';
                    } else {
                        echo 'php/pages/about_us.php';
                    }
                ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    <i class="fas fa-info-circle mr-2"></i>About Us
                </a>
                <a href="<?php 
                    $currentDir = dirname($_SERVER['PHP_SELF']);
                    if (strpos($currentDir, 'php/authentication') !== false) {
                        echo '../../php/pages/contact.php';
                    } elseif (strpos($currentDir, 'php/pages') !== false) {
                        echo 'contact.php';
                    } else {
                        echo 'php/pages/contact.php';
                    }
                ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    <i class="fas fa-envelope mr-2"></i>Contact
                </a>
            </div>
            
            <!-- Right Side - Login and Register -->
            <div class="flex items-center space-x-4 flex-shrink-0">
                <a href="<?php 
                    $currentDir = dirname($_SERVER['PHP_SELF']);
                    if (strpos($currentDir, 'php/authentication') !== false) {
                        echo 'login.php';
                    } elseif (strpos($currentDir, 'php/pages') !== false) {
                        echo '../authentication/login.php';
                    } else {
                        echo 'php/authentication/login.php';
                    }
                ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="<?php 
                    $currentDir = dirname($_SERVER['PHP_SELF']);
                    if (strpos($currentDir, 'php/authentication') !== false) {
                        echo 'register.php';
                    } elseif (strpos($currentDir, 'php/pages') !== false) {
                        echo '../authentication/register.php';
                    } else {
                        echo 'php/authentication/register.php';
                    }
                ?>" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-user-plus mr-2"></i>Register
                </a>
            </div>
        </div>
    </div>
</nav>


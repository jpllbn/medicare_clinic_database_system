<?php $pageTitle = 'Medicare Clinic Database System'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/includes/head.php'; ?>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Main Content -->
    <main class="flex-1">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">Medicare Clinic Database System</h2>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">Comprehensive software solution for Patient and Appointment Management</p>
            <div class="flex justify-center space-x-4">
                <a href="php/authentication/login.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                    Get Started
                </a>
                <a href="#features" class="bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition border-2 border-white">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-center mb-12 text-gray-800">Key Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-chart-line"></i></div>
                    <h4 class="text-xl font-semibold mb-2 text-gray-800">Patient Management</h4>
                    <p class="text-gray-600">Comprehensive patient database system to store, manage, and retrieve patient information efficiently.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-lock"></i></div>
                    <h4 class="text-xl font-semibold mb-2 text-gray-800">Appointment Management</h4>
                    <p class="text-gray-600">Streamlined appointment scheduling and management system to organize and track all clinic appointments.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-bolt"></i></div>
                    <h4 class="text-xl font-semibold mb-2 text-gray-800">Fast & Reliable</h4>
                    <p class="text-gray-600">Quick access to patient and appointment data with streamlined workflows to improve clinic efficiency.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-center mb-12 text-gray-800">Why Choose Our System?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>Easy to Use</h4>
                    <p class="text-gray-600">Intuitive software interface designed for healthcare professionals. No extensive training required.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>Comprehensive Database</h4>
                    <p class="text-gray-600">Store and retrieve patient information and appointment records effortlessly in a centralized database system.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>Secure & Compliant</h4>
                    <p class="text-gray-600">Built with security and privacy standards in mind to protect sensitive patient and appointment data.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>24/7 Access</h4>
                    <p class="text-gray-600">Access your patient and appointment database anytime, anywhere with secure login credentials.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl font-bold mb-4">Ready to Get Started?</h3>
            <p class="text-xl mb-8 text-blue-100">Start using Medicare Clinic Database System today and streamline your patient and appointment management.</p>
            <div class="flex justify-center space-x-4">
                <a href="php/authentication/register.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                    Create Account
                </a>
                <a href="php/authentication/login.php" class="bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition border-2 border-white">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>

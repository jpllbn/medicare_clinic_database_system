<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare Clinic Database System</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Be Vietnam Pro', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">Medicare Clinic</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="php/authentication/login.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">
                        Login
                    </a>
                    <a href="php/authentication/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">Medicare Clinic Database System</h2>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">Streamline your clinic operations with our comprehensive database management solution</p>
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
                    <p class="text-gray-600">Efficiently manage patient records, appointments, and medical history in one centralized system.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-lock"></i></div>
                    <h4 class="text-xl font-semibold mb-2 text-gray-800">Secure Access</h4>
                    <p class="text-gray-600">Robust authentication system ensuring your sensitive medical data remains protected and confidential.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-bolt"></i></div>
                    <h4 class="text-xl font-semibold mb-2 text-gray-800">Fast & Reliable</h4>
                    <p class="text-gray-600">Quick access to patient information and streamlined workflows to improve clinic efficiency.</p>
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
                    <p class="text-gray-600">Intuitive interface designed for healthcare professionals. No extensive training required.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>Comprehensive Records</h4>
                    <p class="text-gray-600">Store and retrieve patient information, medical history, and treatment records effortlessly.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>HIPAA Compliant</h4>
                    <p class="text-gray-600">Built with security and privacy standards in mind to protect patient information.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-3 text-blue-600"><i class="fas fa-check-circle text-blue-600 mr-2"></i>24/7 Access</h4>
                    <p class="text-gray-600">Access your clinic database anytime, anywhere with secure login credentials.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl font-bold mb-4">Ready to Get Started?</h3>
            <p class="text-xl mb-8 text-blue-100">Join our Medicare Clinic Database System today and transform your clinic management.</p>
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

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; <?php echo date('Y'); ?> Medicare Clinic Database System. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>

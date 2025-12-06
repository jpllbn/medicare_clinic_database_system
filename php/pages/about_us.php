<?php $pageTitle = 'About Us - Medicare Clinic'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../../includes/head.php'; ?>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <?php include __DIR__ . '/../../includes/header.php'; ?>

    <!-- Main Content -->
    <main class="flex-1">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">About Medicare</h1>
                <p class="text-xl md:text-2xl text-blue-100">Clinic Database System Software for Patient and Appointment Management</p>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Mission</h2>
                        <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                            Medicare is a comprehensive Clinic Database System Software designed to revolutionize how healthcare facilities manage their operations. Our mission is to provide an efficient, secure, and user-friendly solution for Patient and Appointment Management that helps clinics streamline their workflows and improve service delivery.
                        </p>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            We are committed to developing software solutions that empower healthcare professionals to focus on what matters most - providing quality care to their patients, while our system handles the administrative tasks seamlessly.
                        </p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-8">
                        <i class="fas fa-database text-blue-600 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Reliable System</h3>
                        <p class="text-gray-600">We prioritize data security, system reliability, and user experience in everything we build.</p>
                    </div>
                </div>

                <!-- Values Section -->
                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Our Core Values</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center p-6 bg-gray-50 rounded-lg hover:shadow-lg transition">
                            <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">User-Focused</h3>
                            <p class="text-gray-600">We design our software with healthcare professionals in mind, ensuring intuitive and efficient workflows.</p>
                        </div>

                        <div class="text-center p-6 bg-gray-50 rounded-lg hover:shadow-lg transition">
                            <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Data Security</h3>
                            <p class="text-gray-600">We maintain the highest security standards to protect sensitive patient and appointment information.</p>
                        </div>

                        <div class="text-center p-6 bg-gray-50 rounded-lg hover:shadow-lg transition">
                            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-lightbulb text-purple-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Innovation</h3>
                            <p class="text-gray-600">We continuously improve our software with new features and technologies to enhance clinic management.</p>
                        </div>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">System Features</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                            <i class="fas fa-users text-blue-600 text-3xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800 mb-2">Patient Management</h4>
                            <p class="text-sm text-gray-600">Comprehensive patient database and records management</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                            <i class="fas fa-calendar-check text-green-600 text-3xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800 mb-2">Appointment Scheduling</h4>
                            <p class="text-sm text-gray-600">Easy appointment scheduling and management system</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                            <i class="fas fa-database text-purple-600 text-3xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800 mb-2">Data Management</h4>
                            <p class="text-sm text-gray-600">Secure and organized database system</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                            <i class="fas fa-shield-alt text-orange-600 text-3xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800 mb-2">Secure Access</h4>
                            <p class="text-sm text-gray-600">Robust authentication and data protection</p>
                        </div>
                    </div>
                </div>

                <!-- Team Section -->
                <div class="mt-16 bg-gray-50 rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Why Choose Our System?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Comprehensive Patient Management</h4>
                                <p class="text-gray-600">Efficiently manage all patient records, information, and data in one centralized database system.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Advanced Appointment System</h4>
                                <p class="text-gray-600">Streamlined appointment scheduling, tracking, and management to optimize clinic operations.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">User-Friendly Interface</h4>
                                <p class="text-gray-600">Intuitive software design that requires minimal training and maximizes productivity.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Secure & Reliable</h4>
                                <p class="text-gray-600">Built with security and reliability in mind to protect sensitive patient and appointment data.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>

</html>


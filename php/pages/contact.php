<?php
$errors = [];
$success = '';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $errors[] = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    } else {
        // In a real application, you would send an email or save to database here
        $success = 'Thank you for contacting us! We will get back to you soon.';
        // Reset form
        $name = $email = $subject = $message = '';
    }
}
?>
<?php $pageTitle = 'Contact Us - Medicare Clinic'; ?>
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
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Us</h1>
                <p class="text-xl md:text-2xl text-blue-100">Get in touch with our support team for assistance with the Medicare Clinic Database System</p>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-8">Get in Touch</h2>
                        <p class="text-gray-600 mb-8 text-lg">
                            Have questions about our Clinic Database System Software? Need technical support or want to learn more about our Patient and Appointment Management solutions? We're here to help. Reach out to us through any of the following methods, and we'll respond as soon as possible.
                        </p>

                        <div class="space-y-6">
                            <!-- Address -->
                            <div class="flex items-start">
                                <div class="bg-blue-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Address</h3>
                                    <p class="text-gray-600">123 Healthcare Avenue<br>Medical District, City 12345<br>Country</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-phone text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Phone</h3>
                                    <p class="text-gray-600">
                                        <a href="tel:+1234567890" class="hover:text-blue-600">+1 (234) 567-8900</a><br>
                                        <a href="tel:+1234567891" class="hover:text-blue-600">+1 (234) 567-8901</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start">
                                <div class="bg-purple-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-envelope text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                                    <p class="text-gray-600">
                                        <a href="mailto:info@medicareclinic.com" class="hover:text-blue-600">info@medicareclinic.com</a><br>
                                        <a href="mailto:support@medicareclinic.com" class="hover:text-blue-600">support@medicareclinic.com</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Hours -->
                            <div class="flex items-start">
                                <div class="bg-orange-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Business Hours</h3>
                                    <p class="text-gray-600">
                                        Monday - Friday: 8:00 AM - 6:00 PM<br>
                                        Saturday: 9:00 AM - 2:00 PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-8">
                            <h3 class="font-semibold text-gray-800 mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-blue-600 text-white p-3 rounded-full hover:bg-blue-700 transition">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="bg-blue-400 text-white p-3 rounded-full hover:bg-blue-500 transition">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="bg-pink-600 text-white p-3 rounded-full hover:bg-pink-700 transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="bg-blue-700 text-white p-3 rounded-full hover:bg-blue-800 transition">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-gray-50 rounded-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Send us a Message</h2>

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

                        <form method="POST" action="" class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>Full Name *
                                </label>
                                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    placeholder="Enter your full name">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                                    <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address *
                                </label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    placeholder="Enter your email address">
                            </div>

                            <!-- Subject -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="subject">
                                    <i class="fas fa-tag mr-2 text-blue-600"></i>Subject *
                                </label>
                                <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    placeholder="What is this regarding?">
                            </div>

                            <!-- Message -->
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="message">
                                    <i class="fas fa-comment mr-2 text-blue-600"></i>Message *
                                </label>
                                <textarea id="message" name="message" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    placeholder="Enter your message here..."><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                                <i class="fas fa-paper-plane mr-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>

</html>


<?php
// Process registration form
session_start();

$errors = [];
$old = ['username' => '', 'email' => ''];

// Include DB connection but suppress any direct output from connection file
ob_start();
require_once __DIR__ . '/../includes/connection.php';
ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $old['username'] = htmlspecialchars($username, ENT_QUOTES);
    $old['email'] = htmlspecialchars($email, ENT_QUOTES);

    if ($username === '') {
        $errors[] = 'Username is required.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        // Check existing username or email
        $checkStmt = $conn->prepare('SELECT register_id FROM register_user WHERE username = ? OR email = ?');
        if ($checkStmt) {
            $checkStmt->bind_param('ss', $username, $email);
            $checkStmt->execute();
            $checkStmt->store_result();
            if ($checkStmt->num_rows > 0) {
                $errors[] = 'Username or email already exists.';
            }
            $checkStmt->close();
        } else {
            $errors[] = 'Database error (check query failed).';
        }
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare('INSERT INTO register_user (username, email, password) VALUES (?, ?, ?)');
        if ($insert) {
            $insert->bind_param('sss', $username, $email, $hashed);
            if ($insert->execute()) {
                $insert->close();
                $conn->close();
                header('Location: login.php');
                exit;
            } else {
                $errors[] = 'Failed to create account. Please try again.';
            }
            $insert->close();
        } else {
            $errors[] = 'Database error (insert failed).';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6">Create Account</h2>

        <?php if (!empty($errors)): ?>
            <div class="mb-4">
                <?php foreach ($errors as $err): ?>
                    <p class="text-red-600 text-sm"><?php echo $err; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            
            <!-- Username -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $old['username']; ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your username" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $old['email']; ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your email" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Confirm your password" required>
            </div>

            <!-- Register Button -->
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Create Account
            </button>

            <!-- Link to Login -->
            <p class="text-center text-gray-600 mt-4">
                Already have an account?
                <a href="login.php" class="text-blue-600 hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>
</html>

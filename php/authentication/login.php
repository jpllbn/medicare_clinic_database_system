<?php
// Simple login handler
session_start();
$errors = [];
$old = ['username' => ''];

// Include DB connection but suppress its direct output
ob_start();
require_once __DIR__ . '/../../includes/connection.php';
ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $old['username'] = htmlspecialchars($username, ENT_QUOTES);

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT register_id, username, password FROM register_user WHERE username = ?');
        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $dbUser, $dbHash);
                $stmt->fetch();
                // Ensure $dbHash is a valid string before verifying to avoid passing null
                if (!is_string($dbHash) || $dbHash === '') {
                    $errors[] = 'Invalid username or password.';
                } elseif (password_verify($password, $dbHash)) {
                    // Authenticated
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $dbUser;
                    $stmt->close();
                    $conn->close();
                    header('Location: ../pages/dashboard.php');
                    exit;
                } else {
                    $errors[] = 'Invalid username or password.';
                }
            } else {
                $errors[] = 'Invalid username or password.';
            }
            $stmt->close();
        } else {
            $errors[] = 'Database error (query failed).';
        }
    }
}
?>
<?php $pageTitle = 'Login - Medicare Clinic'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../../includes/head.php'; ?>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <?php include __DIR__ . '/../../includes/header.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-12">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-sm">
        <div class="text-center mb-6">
            <i class="fas fa-user-lock text-blue-600 text-5xl mb-4"></i>
            <h2 class="text-2xl font-bold">Login</h2>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mb-4">
                <?php foreach ($errors as $err): ?>
                    <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i><?php echo $err; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <!-- Username -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="username">
                    <i class="fas fa-user mr-2 text-blue-600"></i>Username
                </label>
                <input type="text" id="username" name="username" value="<?php echo $old['username']; ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your username" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">
                    <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                </label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your password" required>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>

            <!-- Create Account Link -->
            <p class="text-center text-gray-600 mt-4">
                Don't have an account?
                <a href="register.php" class="text-blue-600 hover:underline">
                    <i class="fas fa-user-plus mr-1"></i>Create an account
                </a>
            </p>
        </form>
        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>

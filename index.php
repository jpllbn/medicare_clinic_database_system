<?php
session_start();
// Require login
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-4">Welcome</h1>
        <p class="text-gray-700 mb-6">Hello, <strong><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></strong> — you are logged in.</p>
        <form action="logout.php" method="POST" class="inline-block">
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
        </form>
    </div>
</body>
</html>

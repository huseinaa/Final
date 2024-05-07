<?php
session_start();
require_once 'dbuser.php';  // Adjust the path as needed

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../fe/admin.html'); // Redirect to the frontend admin page
        exit;
    } else {
        $message = 'Login failed. Incorrect username or password.';
    }
}

// Optionally handle the message passing back to HTML via session or query parameters
if (!empty($message)) {
    header("Location: ../fe/login.html?error=" . urlencode($message));
    exit;
}
?>

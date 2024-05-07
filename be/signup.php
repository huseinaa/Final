<?php
require_once 'dbuser.php'; // Adjust this path as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    try {
        $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $email]);
        header("Location: ../fe/admin.html"); // Adjust as necessary to point to the correct admin page
        exit;
    } catch (PDOException $e) {
        // Handle error appropriately
        die("Error: " . $e->getMessage());
    }
}
?>

<?php
require_once 'dbuser.php';  

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['toggle_active'])) {
        $chefId = $_POST['chef_id'];
        $currentStatus = $_POST['current_status'];

        // Toggle the is_active status
        $newStatus = ($currentStatus === '1') ? 0 : 1;
        $updateStmt = $db->prepare("UPDATE chefs SET is_active = ? WHERE id = ?");
        $updateStmt->execute([$newStatus, $chefId]);

        header("Location: ../fe/admin.html");
        exit();
    }

    if (isset($_POST['addPlatter'])) {
        $plattersName = $_POST['plattersName'];
        $description = $_POST['description'];
        $isActive = $_POST['isActive'];

        try {
            $insertStmt = $db->prepare("INSERT INTO chefs (platters, description, is_active) VALUES (?, ?, ?)");
            $insertStmt->execute([$plattersName, $description, $isActive]);
            header("Location: ../fe/admin.html");
            exit;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Fetch chefs and users from the database
    if ($_POST['action'] == 'fetch') {
        $chefsStmt = $db->query("SELECT id, platters, description, is_active FROM chefs");
        $chefs = $chefsStmt->fetchAll(PDO::FETCH_ASSOC);

        $usersStmt = $db->query("SELECT * FROM users");
        $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['chefs' => $chefs, 'users' => $users]);
        exit();
    }
}

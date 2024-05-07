<?php
require_once '../be/dbuser.php';  

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['toggle_active'])) {
        $chefId = $_POST['chef_id'];
        $currentStatus = $_POST['current_status'];

        // Toggle the is_active status
        $newStatus = ($currentStatus === '1') ? 0 : 1;
        $updateStmt = $db->prepare("UPDATE chefs SET is_active = ? WHERE id = ?");
        $updateStmt->execute([$newStatus, $chefId]);

        // Refresh the page to show the updated status
        header("Location: admin.php");
        exit();
    }
}

// Fetch chefs from the database
$chefsStmt = $db->query("SELECT id, platters, description, is_active FROM chefs");
$chefs = $chefsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch users (this section remains the same as you provided)
$usersStmt = $db->query("SELECT * FROM users");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/templatemo.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css"> <!-- Ensure custom CSS is last to override others -->
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="templatemo-title">Admin Dashboard</h1>
            <div>
                <a href="signup.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Admins</a>
                <a href="index.html" class="btn btn-secondary ml-2"><i class="fas fa-home"></i> Home</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Platters</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Platters</th>
                            <th>Description</th>
                            <th>Is Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chefs as $chef): ?>
                        <tr>
                            <td><?= htmlspecialchars($chef['platters']) ?></td>
                            <td><?= htmlspecialchars($chef['description']) ?></td>
                            <td><?= $chef['is_active'] ? 'Yes' : 'No' ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="chef_id" value="<?= $chef['id'] ?>">
                                    <input type="hidden" name="current_status" value="<?= $chef['is_active'] ?>">
                                    <button type="submit" name="toggle_active" class="btn <?= $chef['is_active'] ? 'btn-danger' : 'btn-success' ?>">
                                        <i class="fas <?= $chef['is_active'] ? 'fa-times-circle' : 'fa-check-circle' ?>"></i> <?= $chef['is_active'] ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h2>Users</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['password']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

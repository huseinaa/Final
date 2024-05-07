<?php
    require_once '../be/dbuser.php';  

    // Fetch users
    $usersStmt = $db->query("SELECT * FROM users");
    $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch chefs
    $chefsStmt = $db->query("SELECT * FROM chefs");
    $chefs = $chefsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="signup.php" class="btn btn-primary">Sign Up</a>
        </div>
        <h2>Chefs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Platters</th>
                    <th>Description</th>
                    <th>Is Active</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chefs as $chef): ?>
                    <tr>
                        <td><?= htmlspecialchars($chef['platters']) ?></td>
                        <td><?= htmlspecialchars($chef['description']) ?></td>
                        <td><?= $chef['IS_ACTIVE'] ? 'Yes' : 'No' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Users</h2>
        <table class="table">
            <thead>
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
</body>
</html>

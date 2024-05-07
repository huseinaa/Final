<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Login Page</title>
</head>
<body>
    <?php
    require_once '../be/dbuser.php';  

    $message = '';

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];  

        $stmt = $db->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
        $stmt->execute( $params = ['username' => 'superman', 'password' => 'superman'] )
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: admin.php');  
            exit;
        } else {
            $message = 'Login failed. Incorrect username or password.';
        }
    }
    ?>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php if($message !== ''): ?>
                            <p class="alert alert-danger"><?php echo $message; ?></p>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                                </div>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

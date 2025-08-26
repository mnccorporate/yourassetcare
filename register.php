<?php
require_once 'config/session.php';
require_once 'classes/User.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (!empty($email) && !empty($password) && !empty($full_name) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $user = new User();
            if ($user->register($email, $password, $full_name)) {
                $success = 'Account created successfully! You can now login.';
            } else {
                $error = 'Email already exists or registration failed';
            }
        } else {
            $error = 'Passwords do not match';
        }
    } else {
        $error = 'Please fill in all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register - Your Asset Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="fonts/font-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="images/logo/favicon.png">
</head>
<body class="body bg-surface">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="images/logo/yourassetcare.png" alt="logo" width="200" height="44">
                            <h4 class="mt-3 mb-0">Create Account</h4>
                            <p class="text-muted">Join our platform to access exclusive property details</p>
                        </div>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Create Account</button>
                        </form>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="login.php">Sign in</a></p>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
require_once 'config/session.php';
$isLoggedIn = isLoggedIn();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        // In a real application, you would send an email or save to database
        $success = 'Thank you for your message! We will get back to you soon.';
    } else {
        $error = 'Please fill in all required fields';
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Contact Us - Your Asset Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="fonts/font-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="shortcut icon" href="images/logo/favicon.png">
</head>

<body class="body bg-surface">
    <!-- Header -->
    <header class="main-header fixed-header">
        <div class="header-lower">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-container d-flex justify-content-between align-items-center">
                        <div class="logo-box d-flex">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="images/logo/yourassetcare.png" alt="logo" width="200" height="44">
                                </a>
                            </div>
                        </div>
                        
                        <div class="nav-outer">
                            <nav class="main-menu show navbar-expand-md">
                                <div class="navbar-collapse collapse clearfix">
                                    <ul class="navigation clearfix">
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="properties.php">Properties</a></li>
                                        <li><a href="about.php">About Us</a></li>
                                        <li class="home"><a href="contact.php">Contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        
                        <div class="header-account">
                            <?php if ($isLoggedIn): ?>
                                <a href="#" class="box-avatar dropdown-toggle" data-bs-toggle="dropdown">
                                    <div class="avatar avt-40 round">
                                        <img src="images/avatar/avt-2.jpg" alt="avatar">
                                    </div>
                                    <p class="name"><?php echo htmlspecialchars($_SESSION['user_name']); ?><span class="icon icon-arr-down"></span></p>
                                    <div class="dropdown-menu">
                                        <?php if (isAdmin()): ?>
                                            <a class="dropdown-item" href="admin/dashboard.php">Admin Dashboard</a>
                                        <?php endif; ?>
                                        <a class="dropdown-item" href="dashboard.php">My Dashboard</a>
                                        <a class="dropdown-item" href="logout.php">Logout</a>
                                    </div>
                                </a>
                            <?php else: ?>
                                <div class="flat-bt-top">
                                    <a class="tf-btn primary me-2" href="login.php">Login</a>
                                    <a class="tf-btn secondary" href="register.php">Register</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contact Section -->
    <section class="flat-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-section text-center mb-5">
                        <h2>Contact Us</h2>
                        <p class="text-color-2">Get in touch with our real estate experts</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    
                    <div class="contact-form-wrap">
                        <h4>Send us a Message</h4>
                        <form method="POST" class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="tf-btn primary">Send Message</button>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="contact-info">
                        <h4>Contact Information</h4>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center">
                                <i class="icon icon-mapPin me-3"></i>
                                <div>
                                    <h6>Address</h6>
                                    <p>123 Real Estate Ave, Property City, PC 12345</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center">
                                <i class="icon icon-phone2 me-3"></i>
                                <div>
                                    <h6>Phone</h6>
                                    <p>+1 (555) 123-4567</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center">
                                <i class="icon icon-mail me-3"></i>
                                <div>
                                    <h6>Email</h6>
                                    <p>info@yourassetcare.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <h6>Business Hours</h6>
                            <p>Monday - Friday: 9:00 AM - 6:00 PM<br>
                               Saturday: 10:00 AM - 4:00 PM<br>
                               Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="text-variant-2">©2024 Your Asset Care. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/shortcodes.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
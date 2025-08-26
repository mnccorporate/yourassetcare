<?php
require_once 'config/session.php';
$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>About Us - Your Asset Care</title>
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
                                        <li class="home"><a href="about.php">About Us</a></li>
                                        <li><a href="contact.php">Contact</a></li>
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

    <!-- About Section -->
    <section class="flat-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-section text-center mb-5">
                        <h2>About Your Asset Care</h2>
                        <p class="text-color-2">Your trusted partner in real estate solutions</p>
                    </div>
                </div>
            </div>
            
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h3>Leading Real Estate Platform</h3>
                        <p>Your Asset Care is a comprehensive real estate platform designed to connect property seekers with their dream homes. We provide a seamless experience for both buyers and sellers in the real estate market.</p>
                        
                        <div class="features-list mt-4">
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="icon icon-tick me-3"></i>
                                <span>Verified property listings</span>
                            </div>
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="icon icon-tick me-3"></i>
                                <span>Professional agent network</span>
                            </div>
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="icon icon-tick me-3"></i>
                                <span>Secure transaction process</span>
                            </div>
                            <div class="feature-item d-flex align-items-center mb-3">
                                <i class="icon icon-tick me-3"></i>
                                <span>24/7 customer support</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="images/home/house-1.jpg" alt="About Us" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="flat-counter bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center mb-4">
                    <div class="counter-item">
                        <h3 class="counter-number text-primary">500+</h3>
                        <p>Properties Listed</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-4">
                    <div class="counter-item">
                        <h3 class="counter-number text-primary">200+</h3>
                        <p>Happy Clients</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-4">
                    <div class="counter-item">
                        <h3 class="counter-number text-primary">50+</h3>
                        <p>Expert Agents</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-4">
                    <div class="counter-item">
                        <h3 class="counter-number text-primary">5+</h3>
                        <p>Years Experience</p>
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
<?php
require_once 'config/session.php';
require_once 'classes/Property.php';

$property = new Property();
$properties = $property->getAllProperties(6);
$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Your Asset Care - Real Estate Platform</title>
    <meta name="author" content="yourassetcare.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="fonts/font-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="shortcut icon" href="images/logo/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="images/logo/favicon.png">
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
                                        <li class="home"><a href="index.php">Home</a></li>
                                        <li><a href="properties.php">Properties</a></li>
                                        <li><a href="about.php">About Us</a></li>
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
                        
                        <div class="mobile-nav-toggler mobile-button"><span></span></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="flat-slider home-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="slider-content">
                        <h1 class="heading">Find Your Dream Property</h1>
                        <p class="sub-heading">Discover the perfect home with our comprehensive real estate platform</p>
                        
                        <?php if (!$isLoggedIn): ?>
                            <div class="alert alert-info mt-4">
                                <i class="icon icon-info"></i>
                                <strong>Login to unlock full property details including prices and agent contact information</strong>
                                <div class="mt-2">
                                    <a href="login.php" class="btn btn-primary btn-sm me-2">Login Now</a>
                                    <a href="register.php" class="btn btn-outline-primary btn-sm">Create Account</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success mt-4">
                                <i class="icon icon-tick"></i>
                                <strong>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</strong>
                                You now have access to all property prices and contact details.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Properties Section -->
    <section class="flat-property">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-section text-center">
                        <h2>Featured Properties</h2>
                        <p class="text-color-2">Discover our handpicked selection of premium properties</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php foreach ($properties as $prop): ?>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="homeya-box">
                        <div class="archive-top">
                            <a href="property-details.php?id=<?php echo $prop['id']; ?>" class="images-group">
                                <div class="images-style">
                                    <img src="<?php echo htmlspecialchars($prop['image']); ?>" alt="<?php echo htmlspecialchars($prop['title']); ?>">
                                </div>
                            </a>
                            <div class="top">
                                <ul class="d-flex gap-6">
                                    <li class="flag-tag success">Featured</li>
                                    <li class="flag-tag style-1"><?php echo ucfirst($prop['property_type']); ?></li>
                                </ul>
                            </div>
                            <?php if (!$isLoggedIn): ?>
                                <div class="login-overlay">
                                    <div class="login-prompt">
                                        <i class="icon icon-eye-off"></i>
                                        <p>Login to view price</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="archive-bottom">
                            <div class="content-top">
                                <h6 class="text-capitalize">
                                    <a href="property-details.php?id=<?php echo $prop['id']; ?>" class="link">
                                        <?php echo htmlspecialchars($prop['title']); ?>
                                    </a>
                                </h6>
                                <ul class="meta-list">
                                    <li class="item">
                                        <i class="icon icon-bed"></i>
                                        <span class="text-variant-1"><?php echo $prop['bedrooms']; ?></span>
                                    </li>
                                    <li class="item">
                                        <i class="icon icon-bathtub"></i>
                                        <span class="text-variant-1"><?php echo $prop['bathrooms']; ?></span>
                                    </li>
                                    <li class="item">
                                        <i class="icon icon-ruler"></i>
                                        <span class="text-variant-1"><?php echo $prop['area']; ?> SqFt</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="content-bottom">
                                <div class="d-flex gap-8 align-items-center">
                                    <div class="h7 fw-7">
                                        <?php if ($isLoggedIn): ?>
                                            $<?php echo number_format($prop['price'], 2); ?>
                                        <?php else: ?>
                                            <span class="text-muted price-hidden">
                                                <i class="icon icon-eye-off"></i> Price Hidden
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-8 align-items-center">
                                    <span class="text-variant-1"><?php echo htmlspecialchars($prop['address']); ?></span>
                                </div>
                                <?php if ($isLoggedIn): ?>
                                    <div class="d-flex gap-8 align-items-center mt-2">
                                        <a href="property-details.php?id=<?php echo $prop['id']; ?>" class="tf-btn primary btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex gap-8 align-items-center mt-2">
                                        <a href="login.php" class="tf-btn secondary btn-sm">
                                            Login to Contact
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="properties.php" class="tf-btn primary">View All Properties</a>
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
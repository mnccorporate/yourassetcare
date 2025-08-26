<?php
require_once 'config/session.php';
require_once 'classes/Property.php';

$property_id = $_GET['id'] ?? 0;
$property = new Property();
$prop = $property->getPropertyById($property_id);

if (!$prop) {
    header('Location: properties.php');
    exit();
}

$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($prop['title']); ?> - Your Asset Care</title>
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
                                        <li class="home"><a href="properties.php">Properties</a></li>
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
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Property Details -->
    <section class="flat-property-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="property-detail-wrap">
                        <div class="property-images">
                            <img src="<?php echo htmlspecialchars($prop['image']); ?>" alt="<?php echo htmlspecialchars($prop['title']); ?>" class="img-fluid">
                        </div>
                        
                        <div class="property-info mt-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2><?php echo htmlspecialchars($prop['title']); ?></h2>
                                    <p class="text-variant-1">
                                        <i class="icon icon-mapPin"></i>
                                        <?php echo htmlspecialchars($prop['address']); ?>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <?php if ($isLoggedIn): ?>
                                        <h3 class="text-primary">$<?php echo number_format($prop['price'], 2); ?></h3>
                                        <p class="text-success mb-0">
                                            <i class="icon icon-tick"></i> Price visible - You're logged in
                                        </p>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            <i class="icon icon-eye-off"></i>
                                            <strong>🔒 Price Hidden</strong>
                                            <p class="mb-2">Login to view property price and contact agent</p>
                                            <div class="mt-2">
                                                <a href="login.php" class="btn btn-primary btn-sm me-2">Login</a>
                                                <a href="register.php" class="btn btn-outline-primary btn-sm">Register</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="property-features mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="feature-item text-center">
                                            <i class="icon icon-bed"></i>
                                            <h6><?php echo $prop['bedrooms']; ?></h6>
                                            <span>Bedrooms</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="feature-item text-center">
                                            <i class="icon icon-bathtub"></i>
                                            <h6><?php echo $prop['bathrooms']; ?></h6>
                                            <span>Bathrooms</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="feature-item text-center">
                                            <i class="icon icon-ruler"></i>
                                            <h6><?php echo $prop['area']; ?></h6>
                                            <span>SqFt</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="feature-item text-center">
                                            <i class="icon icon-home"></i>
                                            <h6><?php echo ucfirst($prop['property_type']); ?></h6>
                                            <span>Type</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="property-description">
                                <h4>Description</h4>
                                <p><?php echo nl2br(htmlspecialchars($prop['description'])); ?></p>
                            </div>

                            <?php if ($isLoggedIn): ?>
                                <div class="property-additional-info mt-4">
                                    <h4>Property Information</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li><strong>Property ID:</strong> #<?php echo $prop['id']; ?></li>
                                                <li><strong>Listed:</strong> <?php echo date('F j, Y', strtotime($prop['created_at'])); ?></li>
                                                <li><strong>Status:</strong> <span class="badge bg-success"><?php echo ucfirst($prop['status']); ?></span></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li><strong>Price per SqFt:</strong> $<?php echo number_format($prop['price'] / max($prop['area'], 1), 2); ?></li>
                                                <li><strong>Property Type:</strong> <?php echo ucfirst($prop['property_type']); ?></li>
                                                <li><strong>Last Updated:</strong> <?php echo date('F j, Y', strtotime($prop['updated_at'])); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="property-sidebar">
                        <?php if ($isLoggedIn): ?>
                            <div class="contact-form-wrap">
                                <h5>🏠 Contact Our Agent</h5>
                                <div class="agent-info mb-3 p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <img src="images/avatar/avt-2.jpg" alt="agent" class="rounded-circle me-3" width="50" height="50">
                                        <div>
                                            <h6 class="mb-0">Sarah Johnson</h6>
                                            <p class="text-muted mb-0">Senior Real Estate Agent</p>
                                            <p class="text-muted mb-0">📞 +1 (555) 123-4567</p>
                                        </div>
                                    </div>
                                </div>
                                <form class="contact-form">
                                    <input type="hidden" name="property_id" value="<?php echo $prop['id']; ?>">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="name" placeholder="Your Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email Address" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="tel" class="form-control" name="phone" placeholder="Your Phone Number" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="message" rows="4" placeholder="I'm interested in this property. Please contact me with more details." required></textarea>
                                    </div>
                                    <button type="submit" class="tf-btn primary w-100">
                                        <i class="icon icon-send"></i> Send Message to Agent
                                    </button>
                                </form>
                                
                                <div class="contact-info mt-4 p-3 bg-light rounded">
                                    <h6>Direct Contact</h6>
                                    <p class="mb-2"><i class="icon icon-phone"></i> <strong>Call:</strong> +1 (555) 123-4567</p>
                                    <p class="mb-2"><i class="icon icon-mail"></i> <strong>Email:</strong> sarah@yourassetcare.com</p>
                                    <p class="mb-0"><i class="icon icon-clock-countdown"></i> <strong>Available:</strong> Mon-Fri 9AM-6PM</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="login-prompt">
                                <div class="text-center p-4 bg-light rounded">
                                    <i class="icon icon-eye-off display-4 text-muted mb-3"></i>
                                    <h5>🔒 Login Required</h5>
                                    <p class="text-muted">Sign in to access:</p>
                                    <ul class="list-unstyled text-start">
                                        <li>✓ Property price information</li>
                                        <li>✓ Agent contact details</li>
                                        <li>✓ Direct messaging system</li>
                                        <li>✓ Property comparison tools</li>
                                    </ul>
                                    <div class="d-grid gap-2">
                                        <a href="login.php" class="tf-btn primary">Login to Your Account</a>
                                        <a href="register.php" class="tf-btn secondary">Create New Account</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
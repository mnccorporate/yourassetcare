<?php
require_once 'config/session.php';
require_once 'classes/Property.php';

$property = new Property();
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $properties = $property->searchProperties($search);
} else {
    $properties = $property->getAllProperties();
}

$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Properties - Your Asset Care</title>
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

    <!-- Page Title -->
    <section class="flat-title-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-page">
                        <h2>Properties Listing</h2>
                        <p>Find your perfect property from our extensive collection</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="flat-search-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form method="GET" class="search-form">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search properties by title, address, or description..." 
                                       value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="tf-btn primary w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Properties Grid -->
    <section class="flat-property">
        <div class="container">
            <?php if (!$isLoggedIn): ?>
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="alert alert-info text-center">
                            <i class="icon icon-info"></i>
                            <strong>Login Required for Full Access</strong>
                            <p class="mb-2">Sign in to unlock property prices, agent contact details, and exclusive features</p>
                            <div class="mt-2">
                                <a href="login.php" class="btn btn-primary btn-sm me-2">Login Now</a>
                                <a href="register.php" class="btn btn-outline-primary btn-sm">Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <?php if (empty($properties)): ?>
                    <div class="col-lg-12 text-center">
                        <div class="no-results">
                            <h4>No properties found</h4>
                            <p>Try adjusting your search criteria</p>
                            <a href="properties.php" class="tf-btn primary">View All Properties</a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($properties as $prop): ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
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
                                    <div class="price-overlay">
                                        <div class="overlay-content">
                                            <i class="icon icon-eye-off"></i>
                                            <span>Login Required</span>
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
                                                <span class="text-success fw-bold">$<?php echo number_format($prop['price'], 2); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="icon icon-eye-off"></i> Price Hidden - Login Required
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-8 align-items-center">
                                        <span class="text-variant-1"><?php echo htmlspecialchars($prop['address']); ?></span>
                                    </div>
                                    <div class="d-flex gap-8 align-items-center mt-2">
                                        <?php if ($isLoggedIn): ?>
                                            <a href="property-details.php?id=<?php echo $prop['id']; ?>" class="tf-btn primary btn-sm">
                                                View Details & Contact
                                            </a>
                                        <?php else: ?>
                                            <a href="login.php" class="tf-btn secondary btn-sm">
                                                Login to Contact Agent
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
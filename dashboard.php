<?php
require_once 'config/session.php';
require_once 'classes/Property.php';

requireLogin();

$property = new Property();
$user_properties = $property->getAllProperties(); // In a real app, filter by user
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>User Dashboard - Your Asset Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="fonts/font-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jqueryui.min.css">
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="shortcut icon" href="images/logo/favicon.png">
</head>

<body class="body bg-surface counter-scroll">
    <div id="wrapper">
        <div id="page" class="clearfix">
            <div class="layout-wrap">
                <!-- Header -->
                <header class="main-header fixed-header header-dashboard">
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
                                        <div class="button-show-hide">
                                            <span class="icon icon-categories"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="nav-outer">
                                        <nav class="main-menu show navbar-expand-md">
                                            <div class="navbar-collapse collapse clearfix">
                                                <ul class="navigation clearfix">
                                                    <li><a href="index.php">Home</a></li>
                                                    <li><a href="properties.php">Properties</a></li>
                                                    <li><a href="about.php">About Us</a></li>
                                                    <li><a href="contact.php">Contact</a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                    
                                    <div class="header-account">
                                        <a href="#" class="box-avatar dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="avatar avt-40 round">
                                                <img src="images/avatar/avt-2.jpg" alt="avatar">
                                            </div>
                                            <p class="name"><?php echo htmlspecialchars($_SESSION['user_name']); ?><span class="icon icon-arr-down"></span></p>
                                            <div class="dropdown-menu">
                                                <?php if (isAdmin()): ?>
                                                    <a class="dropdown-item" href="admin/dashboard.php">Admin Dashboard</a>
                                                <?php endif; ?>
                                                <a class="dropdown-item" href="my-profile.html">My Profile</a>
                                                <a class="dropdown-item" href="logout.php">Logout</a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Sidebar -->
                <div class="sidebar-menu-dashboard">
                    <ul class="box-menu-dashboard">
                        <li class="nav-menu-item active">
                            <a class="nav-menu-link" href="dashboard.php">
                                <span class="icon icon-dashboard"></span> Dashboard
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="my-property.html">
                                <span class="icon icon-list-dashes"></span> My Properties
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="my-invoices.html">
                                <span class="icon icon-file-text"></span> My Invoices
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="my-favorites.html">
                                <span class="icon icon-heart"></span> My Favorites
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="reviews.html">
                                <span class="icon icon-review"></span> Reviews
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="my-profile.html">
                                <span class="icon icon-profile"></span> My Profile
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="logout.php">
                                <span class="icon icon-sign-out"></span> Logout
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="main-content-inner">
                        <div class="button-show-hide show-mb">
                            <span class="body-1">Show Dashboard</span>
                        </div>
                        
                        <!-- Welcome Message -->
                        <div class="alert alert-success mb-4">
                            <h5 class="mb-2">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h5>
                            <p class="mb-0">You are now logged in and can view property prices and contact details.</p>
                        </div>
                        
                        <!-- Stats Cards -->
                        <div class="flat-counter-v2 tf-counter">
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-list-dashes"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Available Properties</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="number" data-speed="2000" data-to="<?php echo count($user_properties); ?>"><?php echo count($user_properties); ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-eye"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Price Visibility</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="text-success">Enabled</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-heart"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Favorites</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="number" data-speed="2000" data-to="0">0</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Properties -->
                        <div class="widget-box-2 wd-listing">
                            <h6 class="title">Available Properties</h6>
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Property</th>
                                                <th>Price</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($user_properties, 0, 10) as $prop): ?>
                                            <tr>
                                                <td>
                                                    <div class="listing-box">
                                                        <div class="images">
                                                            <img src="<?php echo htmlspecialchars($prop['image']); ?>" alt="property" style="width: 60px; height: 45px; object-fit: cover;">
                                                        </div>
                                                        <div class="content">
                                                            <div class="title">
                                                                <a href="property-details.php?id=<?php echo $prop['id']; ?>" >
                                                                    <?php echo htmlspecialchars($prop['title']); ?>
                                                                </a>
                                                            </div>
                                                            <div class="text-date"><?php echo htmlspecialchars($prop['address']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="h7 fw-7 text-success">
                                                        ₹<?php echo number_format($prop['price'], 2); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo ucfirst($prop['property_type']); ?></td>
                                                <td>
                                                    <a href="property-details.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="icon icon-eye"></i> View Details
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="properties.php" class="tf-btn primary">Browse All Properties</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="footer-dashboard">
                        <p class="text-variant-2">©2024 Your Asset Care. All Rights Reserved.</p>
                    </div>
                </div>

                <div class="overlay-dashboard"></div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/countto.js"></script>
    <script src="js/shortcodes.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
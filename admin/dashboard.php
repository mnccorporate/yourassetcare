<?php
require_once '../config/session.php';
require_once '../classes/Property.php';
require_once '../classes/User.php';

requireAdmin();

$property = new Property();
$user = new User();

$properties = $property->getAllPropertiesForAdmin();
$users = $user->getAllUsers();
$property_stats = $property->getPropertyStats();
$recent_properties = $property->getRecentProperties(5);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard - Your Asset Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../fonts/font-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    
    <link rel="shortcut icon" href="../images/logo/favicon.png">
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
                                            <a href="../index.php">
                                                <img src="../images/logo/yourassetcare.png" alt="logo" width="200" height="44">
                                            </a>
                                        </div>
                                        <div class="button-show-hide">
                                            <span class="icon icon-categories"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="header-account">
                                        <a href="#" class="box-avatar dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="avatar avt-40 round">
                                                <img src="../images/avatar/avt-2.jpg" alt="avatar">
                                            </div>
                                            <p class="name"><?php echo htmlspecialchars($_SESSION['user_name']); ?><span class="icon icon-arr-down"></span></p>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="../index.php">View Website</a>
                                                <a class="dropdown-item" href="../logout.php">Logout</a>
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
                            <a class="nav-menu-link" href="properties.php">
                                <span class="icon icon-list-dashes"></span> Manage Properties
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="users.php">
                                <span class="icon icon-profile"></span> Manage Users
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="add-property.php">
                                <span class="icon icon-plus"></span> Add Property
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="../logout.php">
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
                            <h5 class="mb-2">Welcome to Admin Dashboard, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h5>
                            <p class="mb-0">Manage your real estate platform from this central dashboard.</p>
                        </div>
                        
                        <!-- Stats Cards -->
                        <div class="flat-counter-v2 tf-counter">
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-list-dashes"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Total Properties</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="number" data-speed="2000" data-to="<?php echo $property_stats['total']; ?>"><?php echo $property_stats['total']; ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-profile"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Total Users</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="number" data-speed="2000" data-to="<?php echo count($users); ?>"><?php echo count($users); ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-eye"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Active Listings</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="number" data-speed="2000" data-to="<?php echo $property_stats['active']; ?>"><?php echo $property_stats['active']; ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="counter-box">
                                <div class="box-icon w-68 round">
                                    <span class="icon icon-sold"></span>
                                </div>
                                <div class="content-box">
                                    <div class="title-count">Sold Properties</div>
                                    <div class="d-flex align-items-end">
                                        <h6 class="number" data-speed="2000" data-to="<?php echo $property_stats['sold']; ?>"><?php echo $property_stats['sold']; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="widget-box-2">
                                    <h6 class="title">Quick Actions</h6>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <a href="add-property.php" class="tf-btn primary">
                                            <i class="icon icon-plus"></i> Add New Property
                                        </a>
                                        <a href="properties.php" class="tf-btn secondary">
                                            <i class="icon icon-list-dashes"></i> Manage Properties
                                        </a>
                                        <a href="users.php" class="tf-btn secondary">
                                            <i class="icon icon-profile"></i> Manage Users
                                        </a>
                                        <a href="../index.php" class="tf-btn secondary">
                                            <i class="icon icon-eye"></i> View Website
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Properties -->
                        <div class="widget-box-2 wd-listing">
                            <h6 class="title">Recent Properties</h6>
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Property</th>
                                                <th>Price</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_properties as $prop): ?>
                                            <tr>
                                                <td>
                                                    <div class="listing-box">
                                                        <div class="images">
                                                            <img src="../<?php echo htmlspecialchars($prop['image']); ?>" alt="property" style="width: 60px; height: 45px; object-fit: cover;">
                                                        </div>
                                                        <div class="content">
                                                            <div class="title">
                                                                <a href="../property-details.php?id=<?php echo $prop['id']; ?>" class="link">
                                                                    <?php echo htmlspecialchars($prop['title']); ?>
                                                                </a>
                                                            </div>
                                                            <div class="text-date"><?php echo htmlspecialchars($prop['address']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$<?php echo number_format($prop['price'], 2); ?></td>
                                                <td><?php echo ucfirst($prop['property_type']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $prop['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($prop['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M j, Y', strtotime($prop['created_at'])); ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="edit-property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="icon icon-edit"></i>
                                                        </a>
                                                        <a href="../property-details.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-info">
                                                            <i class="icon icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="properties.php" class="tf-btn primary">View All Properties</a>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Users -->
                        <div class="widget-box-2 wd-listing">
                            <h6 class="title">Recent Users</h6>
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($users, 0, 5) as $u): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avt-40 round me-3">
                                                            <img src="../images/avatar/avt-2.jpg" alt="avatar">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?php echo htmlspecialchars($u['full_name']); ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $u['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                                        <?php echo ucfirst($u['role']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="users.php" class="tf-btn primary">View All Users</a>
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

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugin.js"></script>
    <script src="../js/countto.js"></script>
    <script src="../js/shortcodes.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
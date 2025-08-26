<?php
require_once '../config/session.php';
require_once '../classes/Property.php';
require_once '../classes/User.php';
require_once '../classes/Contact.php';

requireAdmin();

$property = new Property();
$user = new User();
$contact = new Contact();

$properties = $property->getAllPropertiesForAdmin();
$users = $user->getAllUsers();
$messages = $contact->getAllMessages();
$property_stats = $property->getPropertyStats();
$recent_properties = $property->getRecentProperties(5);
$unread_messages = array_filter($messages, function($msg) { return !$msg['is_read']; });
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
    
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stats-card.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .stats-card.info {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
        }
        .stats-card .icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .stats-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        .quick-action-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .activity-item {
            padding: 15px;
            border-left: 3px solid #007bff;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .activity-item.property {
            border-left-color: #28a745;
        }
        .activity-item.user {
            border-left-color: #17a2b8;
        }
        .activity-item.message {
            border-left-color: #ffc107;
        }
    </style>
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
                                <span class="badge bg-primary ms-2"><?php echo count($properties); ?></span>
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="users.php">
                                <span class="icon icon-profile"></span> Manage Users
                                <span class="badge bg-info ms-2"><?php echo count($users); ?></span>
                            </a>
                        </li>
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="messages.php">
                                <span class="icon icon-messages"></span> Messages
                                <?php if (count($unread_messages) > 0): ?>
                                    <span class="badge bg-warning ms-2"><?php echo count($unread_messages); ?></span>
                                <?php endif; ?>
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
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="alert alert-success border-0 shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="icon icon-dashboard me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h5 class="mb-1">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h5>
                                            <p class="mb-0">Here's what's happening with your real estate platform today.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats Cards -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number"><?php echo $property_stats['total']; ?></div>
                                            <div>Total Properties</div>
                                        </div>
                                        <i class="icon icon-list-dashes icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card success">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number"><?php echo $property_stats['active']; ?></div>
                                            <div>Active Listings</div>
                                        </div>
                                        <i class="icon icon-eye icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card warning">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number"><?php echo count($users); ?></div>
                                            <div>Total Users</div>
                                        </div>
                                        <i class="icon icon-profile icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card info">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number"><?php echo count($unread_messages); ?></div>
                                            <div>Unread Messages</div>
                                        </div>
                                        <i class="icon icon-messages icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="widget-box-2">
                                    <h6 class="title mb-4">🚀 Quick Actions</h6>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <div class="quick-action-card">
                                                <i class="icon icon-plus text-primary mb-3" style="font-size: 2rem;"></i>
                                                <h6>Add Property</h6>
                                                <p class="text-muted small">List a new property</p>
                                                <a href="add-property.php" class="tf-btn primary btn-sm">Add Now</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <div class="quick-action-card">
                                                <i class="icon icon-list-dashes text-success mb-3" style="font-size: 2rem;"></i>
                                                <h6>Manage Properties</h6>
                                                <p class="text-muted small">Edit existing listings</p>
                                                <a href="properties.php" class="tf-btn success btn-sm">Manage</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <div class="quick-action-card">
                                                <i class="icon icon-profile text-info mb-3" style="font-size: 2rem;"></i>
                                                <h6>User Management</h6>
                                                <p class="text-muted small">Manage user accounts</p>
                                                <a href="users.php" class="tf-btn info btn-sm">View Users</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <div class="quick-action-card">
                                                <i class="icon icon-messages text-warning mb-3" style="font-size: 2rem;"></i>
                                                <h6>Messages</h6>
                                                <p class="text-muted small">View contact inquiries</p>
                                                <a href="messages.php" class="tf-btn warning btn-sm">
                                                    Check Messages
                                                    <?php if (count($unread_messages) > 0): ?>
                                                        <span class="badge bg-danger ms-1"><?php echo count($unread_messages); ?></span>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Recent Properties -->
                            <div class="col-lg-8">
                                <div class="widget-box-2 wd-listing">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="title">📋 Recent Properties</h6>
                                        <a href="properties.php" class="tf-btn secondary btn-sm">View All</a>
                                    </div>
                                    <div class="wrap-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Property</th>
                                                        <th>Price</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (empty($recent_properties)): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <i class="icon icon-list-dashes text-muted mb-2" style="font-size: 2rem;"></i>
                                                            <h6>No properties yet</h6>
                                                            <p class="text-muted">Start by adding your first property</p>
                                                            <a href="add-property.php" class="tf-btn primary btn-sm">Add Property</a>
                                                        </td>
                                                    </tr>
                                                    <?php else: ?>
                                                        <?php foreach ($recent_properties as $prop): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="listing-box">
                                                                    <div class="images">
                                                                        <img src="../<?php echo htmlspecialchars($prop['image']); ?>" alt="property" style="width: 60px; height: 45px; object-fit: cover; border-radius: 8px;">
                                                                    </div>
                                                                    <div class="content ms-3">
                                                                        <div class="title">
                                                                            <a href="../property-details.php?id=<?php echo $prop['id']; ?>" class="link text-decoration-none">
                                                                                <?php echo htmlspecialchars($prop['title']); ?>
                                                                            </a>
                                                                        </div>
                                                                        <div class="text-date text-muted small"><?php echo htmlspecialchars($prop['address']); ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><strong>$<?php echo number_format($prop['price'], 2); ?></strong></td>
                                                            <td><span class="badge bg-light text-dark"><?php echo ucfirst($prop['property_type']); ?></span></td>
                                                            <td>
                                                                <span class="badge bg-<?php echo $prop['status'] === 'active' ? 'success' : ($prop['status'] === 'sold' ? 'danger' : 'secondary'); ?>">
                                                                    <?php echo ucfirst($prop['status']); ?>
                                                                </span>
                                                            </td>
                                                            <td class="text-muted"><?php echo date('M j, Y', strtotime($prop['created_at'])); ?></td>
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <a href="edit-property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                                        <i class="icon icon-edit"></i>
                                                                    </a>
                                                                    <a href="../property-details.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-info" title="View">
                                                                        <i class="icon icon-eye"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Feed -->
                            <div class="col-lg-4">
                                <div class="widget-box-2">
                                    <h6 class="title mb-4">📈 Recent Activity</h6>
                                    <div class="activity-feed">
                                        <?php foreach (array_slice($recent_properties, 0, 3) as $prop): ?>
                                        <div class="activity-item property">
                                            <div class="d-flex align-items-center">
                                                <i class="icon icon-plus text-success me-2"></i>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">New Property Added</h6>
                                                    <p class="mb-0 small text-muted"><?php echo htmlspecialchars($prop['title']); ?></p>
                                                    <small class="text-muted"><?php echo date('M j, g:i A', strtotime($prop['created_at'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        
                                        <?php foreach (array_slice($users, 0, 2) as $u): ?>
                                        <div class="activity-item user">
                                            <div class="d-flex align-items-center">
                                                <i class="icon icon-profile text-info me-2"></i>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">New User Registered</h6>
                                                    <p class="mb-0 small text-muted"><?php echo htmlspecialchars($u['full_name']); ?></p>
                                                    <small class="text-muted"><?php echo date('M j, g:i A', strtotime($u['created_at'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        
                                        <?php foreach (array_slice($unread_messages, 0, 2) as $msg): ?>
                                        <div class="activity-item message">
                                            <div class="d-flex align-items-center">
                                                <i class="icon icon-messages text-warning me-2"></i>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">New Message</h6>
                                                    <p class="mb-0 small text-muted">From <?php echo htmlspecialchars($msg['name']); ?></p>
                                                    <small class="text-muted"><?php echo date('M j, g:i A', strtotime($msg['created_at'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        
                                        <?php if (empty($recent_properties) && empty($unread_messages)): ?>
                                        <div class="text-center py-4">
                                            <i class="icon icon-dashboard text-muted mb-2" style="font-size: 2rem;"></i>
                                            <h6>No recent activity</h6>
                                            <p class="text-muted small">Activity will appear here as you manage your platform</p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Overview -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="widget-box-2">
                                    <h6 class="title mb-4">📊 Property Overview</h6>
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <div class="p-3 bg-light rounded">
                                                <h4 class="text-success mb-1"><?php echo $property_stats['active']; ?></h4>
                                                <small class="text-muted">Active Properties</small>
                                            </div>
                                        </div>
                                        <div class="col-6 text-center">
                                            <div class="p-3 bg-light rounded">
                                                <h4 class="text-danger mb-1"><?php echo $property_stats['sold']; ?></h4>
                                                <small class="text-muted">Sold Properties</small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($property_stats['avg_price']): ?>
                                    <div class="mt-3 p-3 bg-primary text-white rounded text-center">
                                        <h5 class="mb-1">$<?php echo number_format($property_stats['avg_price'], 2); ?></h5>
                                        <small>Average Property Price</small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget-box-2">
                                    <h6 class="title mb-4">🎯 Quick Stats</h6>
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            <span>Properties this month</span>
                                            <span class="badge bg-primary rounded-pill"><?php echo count(array_filter($properties, function($p) { return date('Y-m', strtotime($p['created_at'])) === date('Y-m'); })); ?></span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            <span>New users this month</span>
                                            <span class="badge bg-info rounded-pill"><?php echo count(array_filter($users, function($u) { return date('Y-m', strtotime($u['created_at'])) === date('Y-m'); })); ?></span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            <span>Messages today</span>
                                            <span class="badge bg-warning rounded-pill"><?php echo count(array_filter($messages, function($m) { return date('Y-m-d', strtotime($m['created_at'])) === date('Y-m-d'); })); ?></span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            <span>Admin users</span>
                                            <span class="badge bg-danger rounded-pill"><?php echo count(array_filter($users, function($u) { return $u['role'] === 'admin'; })); ?></span>
                                        </div>
                                    </div>
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
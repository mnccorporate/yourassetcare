<?php
require_once '../config/session.php';
require_once '../classes/Property.php';

requireAdmin();

$property = new Property();

// Handle delete action
if (isset($_GET['delete'])) {
    $property->deleteProperty($_GET['delete']);
    header('Location: properties.php');
    exit();
}

// Handle toggle status action
if (isset($_GET['toggle'])) {
    $property->togglePropertyStatus($_GET['toggle']);
    header('Location: properties.php');
    exit();
}

// Handle filtering
$status_filter = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';

if ($status_filter !== 'all') {
    $properties = $property->getPropertiesByStatus($status_filter);
} elseif (!empty($search)) {
    $properties = $property->searchProperties($search);
} else {
    $properties = $property->getAllPropertiesForAdmin();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Manage Properties - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../fonts/font-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    
    <link rel="shortcut icon" href="../images/logo/favicon.png">
</head>

<body class="body bg-surface">
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
                                        <div class="flat-bt-top">
                                            <a class="tf-btn primary" href="add-property.php">Add Property</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Sidebar -->
                <div class="sidebar-menu-dashboard">
                    <ul class="box-menu-dashboard">
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="dashboard.php">
                                <span class="icon icon-dashboard"></span> Dashboard
                            </a>
                        </li>
                        <li class="nav-menu-item active">
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
                    <div class="main-content-inner wrap-dashboard-content">
                        <div class="button-show-hide show-mb">
                            <span class="body-1">Show Dashboard</span>
                        </div>
                        
                        <!-- Filters -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="widget-box-2">
                                    <h6 class="title">Filter Properties</h6>
                                    <form method="GET" class="row g-3">
                                        <div class="col-md-4">
                                            <select name="status" class="form-control">
                                                <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                                                <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="inactive" <?php echo $status_filter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="sold" <?php echo $status_filter === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Search properties..." value="<?php echo htmlspecialchars($search); ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="tf-btn primary w-100">Filter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-box-2 wd-listing">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="title">All Properties (<?php echo count($properties); ?> found)</h6>
                                <a href="add-property.php" class="tf-btn primary">Add New Property</a>
                            </div>
                            
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
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($properties)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <div class="py-4">
                                                        <h5>No properties found</h5>
                                                        <p class="text-muted">Try adjusting your filters or add a new property.</p>
                                                        <a href="add-property.php" class="tf-btn primary">Add New Property</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($properties as $prop): ?>
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
                                                        <a href="?toggle=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-warning" 
                                                           title="Toggle Status">
                                                            <i class="icon icon-eye<?php echo $prop['status'] === 'active' ? '-off' : ''; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this property?')">
                                                            <i class="icon icon-trash"></i>
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
    <script src="../js/shortcodes.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
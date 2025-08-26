<?php
require_once '../config/session.php';
require_once '../classes/Property.php';

requireAdmin();

$property = new Property();

// Handle delete action
if (isset($_GET['delete'])) {
    $property->deleteProperty($_GET['delete']);
    header('Location: properties.php?deleted=1');
    exit();
}

// Handle toggle status action
if (isset($_GET['toggle'])) {
    $property->togglePropertyStatus($_GET['toggle']);
    header('Location: properties.php?toggled=1');
    exit();
}

// Handle filtering
$status_filter = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';
$type_filter = $_GET['type'] ?? 'all';

if ($status_filter !== 'all') {
    $properties = $property->getPropertiesByStatus($status_filter);
} elseif (!empty($search)) {
    $properties = $property->searchProperties($search);
} else {
    $properties = $property->getAllPropertiesForAdmin();
}

// Filter by type if specified
if ($type_filter !== 'all') {
    $properties = array_filter($properties, function($prop) use ($type_filter) {
        return $prop['property_type'] === $type_filter;
    });
}

$property_stats = $property->getPropertyStats();
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
    
    <style>
        .filter-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .property-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            border-radius: 10px;
        }
        .property-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
        }
        .action-buttons .btn {
            margin: 0 2px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
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
                                            <a class="tf-btn primary" href="add-property.php">
                                                <i class="icon icon-plus"></i> Add Property
                                            </a>
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
                            <a class="nav-menu-link" href="messages.php">
                                <span class="icon icon-messages"></span> Messages
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
                        
                        <!-- Success Messages -->
                        <?php if (isset($_GET['deleted'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon icon-tick"></i> Property deleted successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['toggled'])): ?>
                            <div class="alert alert-info alert-dismissible fade show">
                                <i class="icon icon-tick"></i> Property status updated successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Stats Overview -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="icon icon-list-dashes text-primary mb-2" style="font-size: 2rem;"></i>
                                        <h4 class="mb-1"><?php echo $property_stats['total']; ?></h4>
                                        <small class="text-muted">Total Properties</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="icon icon-eye text-success mb-2" style="font-size: 2rem;"></i>
                                        <h4 class="mb-1"><?php echo $property_stats['active']; ?></h4>
                                        <small class="text-muted">Active Listings</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="icon icon-sold text-danger mb-2" style="font-size: 2rem;"></i>
                                        <h4 class="mb-1"><?php echo $property_stats['sold']; ?></h4>
                                        <small class="text-muted">Sold Properties</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="icon icon-eye-off text-warning mb-2" style="font-size: 2rem;"></i>
                                        <h4 class="mb-1"><?php echo $property_stats['total'] - $property_stats['active'] - $property_stats['sold']; ?></h4>
                                        <small class="text-muted">Inactive Properties</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filters -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="filter-card">
                                    <h6 class="mb-3">🔍 Filter & Search Properties</h6>
                                    <form method="GET" class="row g-3">
                                        <div class="col-md-3">
                                            <select name="status" class="form-control">
                                                <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                                                <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="inactive" <?php echo $status_filter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="sold" <?php echo $status_filter === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="type" class="form-control">
                                                <option value="all" <?php echo $type_filter === 'all' ? 'selected' : ''; ?>>All Types</option>
                                                <option value="apartment" <?php echo $type_filter === 'apartment' ? 'selected' : ''; ?>>Apartment</option>
                                                <option value="villa" <?php echo $type_filter === 'villa' ? 'selected' : ''; ?>>Villa</option>
                                                <option value="studio" <?php echo $type_filter === 'studio' ? 'selected' : ''; ?>>Studio</option>
                                                <option value="office" <?php echo $type_filter === 'office' ? 'selected' : ''; ?>>Office</option>
                                                <option value="townhouse" <?php echo $type_filter === 'townhouse' ? 'selected' : ''; ?>>Townhouse</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Search by title, address..." value="<?php echo htmlspecialchars($search); ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="tf-btn primary w-100">
                                                <i class="icon icon-search"></i> Filter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-box-2 wd-listing">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="title">🏠 Properties Management (<?php echo count($properties); ?> found)</h6>
                                <div class="d-flex gap-2">
                                    <a href="add-property.php" class="tf-btn primary">
                                        <i class="icon icon-plus"></i> Add New Property
                                    </a>
                                    <a href="?status=all" class="tf-btn secondary">
                                        <i class="icon icon-refresh"></i> Reset Filters
                                    </a>
                                </div>
                            </div>
                            
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Property Details</th>
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
                                                <td colspan="6" class="text-center py-5">
                                                    <div>
                                                        <i class="icon icon-list-dashes text-muted mb-3" style="font-size: 3rem;"></i>
                                                        <h5>No properties found</h5>
                                                        <p class="text-muted">Try adjusting your filters or add a new property to get started.</p>
                                                        <div class="mt-3">
                                                            <a href="add-property.php" class="tf-btn primary me-2">
                                                                <i class="icon icon-plus"></i> Add New Property
                                                            </a>
                                                            <a href="?status=all" class="tf-btn secondary">
                                                                <i class="icon icon-refresh"></i> Reset Filters
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($properties as $prop): ?>
                                            <tr class="property-card">
                                                <td>
                                                    <div class="listing-box d-flex align-items-center">
                                                        <div class="images me-3">
                                                            <img src="../<?php echo htmlspecialchars($prop['image']); ?>" alt="property" 
                                                                 style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                        </div>
                                                        <div class="content">
                                                            <div class="title">
                                                                <a href="../property-details.php?id=<?php echo $prop['id']; ?>" class="link text-decoration-none fw-bold">
                                                                    <?php echo htmlspecialchars($prop['title']); ?>
                                                                </a>
                                                            </div>
                                                            <div class="text-date text-muted">
                                                                <i class="icon icon-mapPin"></i>
                                                                <?php echo htmlspecialchars($prop['address']); ?>
                                                            </div>
                                                            <div class="property-meta mt-1">
                                                                <small class="text-muted">
                                                                    <i class="icon icon-bed"></i> <?php echo $prop['bedrooms']; ?> beds
                                                                    <i class="icon icon-bathtub ms-2"></i> <?php echo $prop['bathrooms']; ?> baths
                                                                    <i class="icon icon-ruler ms-2"></i> <?php echo $prop['area']; ?> sqft
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong class="text-success">$<?php echo number_format($prop['price'], 2); ?></strong>
                                                    <?php if ($prop['area'] > 0): ?>
                                                        <br><small class="text-muted">$<?php echo number_format($prop['price'] / $prop['area'], 2); ?>/sqft</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <i class="icon icon-<?php echo $prop['property_type']; ?>"></i>
                                                        <?php echo ucfirst($prop['property_type']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="status-badge bg-<?php echo $prop['status'] === 'active' ? 'success' : ($prop['status'] === 'sold' ? 'danger' : 'secondary'); ?>">
                                                        <?php echo ucfirst($prop['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-muted">
                                                    <?php echo date('M j, Y', strtotime($prop['created_at'])); ?>
                                                    <br><small><?php echo date('g:i A', strtotime($prop['created_at'])); ?></small>
                                                </td>
                                                <td>
                                                    <div class="action-buttons d-flex">
                                                        <a href="edit-property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit Property">
                                                            <i class="icon icon-edit"></i>
                                                        </a>
                                                        <a href="../property-details.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-info" title="View Property">
                                                            <i class="icon icon-eye"></i>
                                                        </a>
                                                        <a href="?toggle=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-warning" 
                                                           title="Toggle Status">
                                                            <i class="icon icon-eye<?php echo $prop['status'] === 'active' ? '-off' : ''; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('⚠️ Are you sure you want to delete this property? This action cannot be undone.')" title="Delete Property">
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
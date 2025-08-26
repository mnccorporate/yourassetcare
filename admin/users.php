<?php
require_once '../config/session.php';
require_once __DIR__ . '/../classes/User.php';

requireAdmin();

$user = new User();

// Handle delete action
if (isset($_GET['delete'])) {
    $stmt = $user->conn->prepare("DELETE FROM users WHERE id = :id AND role != 'admin'");
    $stmt->bindParam(':id', $_GET['delete']);
    $stmt->execute();
    header('Location: users.php?deleted=1');
    exit();
}

// Handle role change
if (isset($_GET['promote']) && isset($_GET['user_id'])) {
    $stmt = $user->conn->prepare("UPDATE users SET role = 'admin' WHERE id = :id AND role != 'admin'");
    $stmt->bindParam(':id', $_GET['user_id']);
    $stmt->execute();
    header('Location: users.php?promoted=1');
    exit();
}

$users = $user->getAllUsers();
$user_stats = [
    'total' => count($users),
    'admins' => count(array_filter($users, function($u) { return $u['role'] === 'admin'; })),
    'regular' => count(array_filter($users, function($u) { return $u['role'] === 'user'; })),
    'recent' => count(array_filter($users, function($u) { return strtotime($u['created_at']) > strtotime('-30 days'); }))
];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Manage Users - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../fonts/font-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    
    <link rel="shortcut icon" href="../images/logo/favicon.png">
    
    <style>
        .user-card {
            transition: all 0.3s ease;
            border-radius: 10px;
        }
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .role-badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
        }
        .stats-overview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
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
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="properties.php">
                                <span class="icon icon-list-dashes"></span> Manage Properties
                            </a>
                        </li>
                        <li class="nav-menu-item active">
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
                                <i class="icon icon-tick"></i> User deleted successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['promoted'])): ?>
                            <div class="alert alert-info alert-dismissible fade show">
                                <i class="icon icon-tick"></i> User promoted to admin successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- User Stats Overview -->
                        <div class="stats-overview">
                            <h5 class="mb-4">👥 User Management Overview</h5>
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <h3 class="mb-1"><?php echo $user_stats['total']; ?></h3>
                                    <small>Total Users</small>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3 class="mb-1"><?php echo $user_stats['admins']; ?></h3>
                                    <small>Admin Users</small>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3 class="mb-1"><?php echo $user_stats['regular']; ?></h3>
                                    <small>Regular Users</small>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3 class="mb-1"><?php echo $user_stats['recent']; ?></h3>
                                    <small>New This Month</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-box-2 wd-listing">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="title">👤 All Users (<?php echo count($users); ?> total)</h6>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-primary">Admin: <?php echo $user_stats['admins']; ?></span>
                                    <span class="badge bg-info">Users: <?php echo $user_stats['regular']; ?></span>
                                </div>
                            </div>
                            
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User Information</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($users)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <i class="icon icon-profile text-muted mb-3" style="font-size: 3rem;"></i>
                                                    <h5>No users found</h5>
                                                    <p class="text-muted">Users will appear here when they register on your platform.</p>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                                <?php foreach ($users as $u): ?>
                                                <tr class="user-card">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="../images/avatar/avt-2.jpg" alt="avatar" class="user-avatar me-3">
                                                            <div>
                                                                <h6 class="mb-1"><?php echo htmlspecialchars($u['full_name']); ?></h6>
                                                                <small class="text-muted">ID: #<?php echo $u['id']; ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <?php echo htmlspecialchars($u['email']); ?>
                                                            <?php if ($u['role'] === 'admin'): ?>
                                                                <br><small class="text-primary">✓ Verified Admin</small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="role-badge bg-<?php echo $u['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                                            <i class="icon icon-<?php echo $u['role'] === 'admin' ? 'star' : 'profile'; ?>"></i>
                                                            <?php echo ucfirst($u['role']); ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-muted">
                                                        <?php echo date('M j, Y', strtotime($u['created_at'])); ?>
                                                        <br><small><?php echo date('g:i A', strtotime($u['created_at'])); ?></small>
                                                        <?php if (strtotime($u['created_at']) > strtotime('-7 days')): ?>
                                                            <span class="badge bg-success ms-1">New</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <?php if ($u['role'] !== 'admin'): ?>
                                                                <a href="?promote=1&user_id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-success" 
                                                                   onclick="return confirm('Are you sure you want to promote this user to admin?')" title="Promote to Admin">
                                                                    <i class="icon icon-star"></i>
                                                                </a>
                                                                <a href="?delete=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                                   onclick="return confirm('⚠️ Are you sure you want to delete this user? This action cannot be undone.')" title="Delete User">
                                                                    <i class="icon icon-trash"></i>
                                                                </a>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning">
                                                                    <i class="icon icon-star"></i> Protected Admin
                                                                </span>
                                                            <?php endif; ?>
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
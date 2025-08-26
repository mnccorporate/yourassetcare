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
    header('Location: users.php');
    exit();
}

$users = $user->getAllUsers();
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
                        
                        <div class="widget-box-2 wd-listing">
                            <h6 class="title">Manage Users</h6>
                            
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $u): ?>
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
                                                <td>
                                                    <?php if ($u['role'] !== 'admin'): ?>
                                                        <a href="?delete=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this user?')">
                                                            <i class="icon icon-trash"></i> Delete
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">Protected</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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
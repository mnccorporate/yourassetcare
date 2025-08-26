<?php
require_once '../config/session.php';
require_once '../classes/Contact.php';

requireAdmin();

$contact = new Contact();

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    
    switch ($action) {
        case 'read':
            $contact->markAsRead($id);
            break;
        case 'delete':
            $contact->deleteMessage($id);
            break;
    }
    
    header('Location: messages.php');
    exit();
}

$messages = $contact->getAllMessages();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Contact Messages - Admin Panel</title>
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
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="users.php">
                                <span class="icon icon-profile"></span> Manage Users
                            </a>
                        </li>
                        <li class="nav-menu-item active">
                            <a class="nav-menu-link" href="messages.php">
                                <span class="icon icon-messages"></span> Contact Messages
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
                            <h6 class="title">Contact Messages (<?php echo count($messages); ?>)</h6>
                            
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Contact Info</th>
                                                <th>Property</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($messages)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <div class="py-4">
                                                        <h5>No messages yet</h5>
                                                        <p class="text-muted">Contact messages will appear here when users inquire about properties.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                                <?php foreach ($messages as $msg): ?>
                                                <tr class="<?php echo !$msg['is_read'] ? 'table-warning' : ''; ?>">
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-1"><?php echo htmlspecialchars($msg['name']); ?></h6>
                                                            <p class="mb-0 small text-muted"><?php echo htmlspecialchars($msg['email']); ?></p>
                                                            <?php if ($msg['phone']): ?>
                                                                <p class="mb-0 small text-muted"><?php echo htmlspecialchars($msg['phone']); ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if ($msg['property_title']): ?>
                                                            <a href="../property-details.php?id=<?php echo $msg['property_id']; ?>" class="text-decoration-none">
                                                                <?php echo htmlspecialchars($msg['property_title']); ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">General Inquiry</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="message-preview">
                                                            <?php echo htmlspecialchars(substr($msg['message'], 0, 100)); ?>
                                                            <?php if (strlen($msg['message']) > 100): ?>...<?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td><?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?></td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <?php if (!$msg['is_read']): ?>
                                                                <a href="?action=read&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-success" title="Mark as Read">
                                                                    <i class="icon icon-tick"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <a href="?action=delete&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                               onclick="return confirm('Are you sure you want to delete this message?')" title="Delete">
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
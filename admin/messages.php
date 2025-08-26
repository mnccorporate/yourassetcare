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
            header('Location: messages.php?read=1');
            exit();
        case 'delete':
            $contact->deleteMessage($id);
            header('Location: messages.php?deleted=1');
            exit();
    }
}

$messages = $contact->getAllMessages();
$unread_count = count(array_filter($messages, function($msg) { return !$msg['is_read']; }));
$today_count = count(array_filter($messages, function($msg) { return date('Y-m-d', strtotime($msg['created_at'])) === date('Y-m-d'); }));
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
    
    <style>
        .message-card {
            transition: all 0.3s ease;
            border-radius: 10px;
        }
        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .unread-message {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        .message-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .stats-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .priority-high {
            border-left: 4px solid #dc3545;
        }
        .priority-medium {
            border-left: 4px solid #ffc107;
        }
        .priority-low {
            border-left: 4px solid #28a745;
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
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="users.php">
                                <span class="icon icon-profile"></span> Manage Users
                            </a>
                        </li>
                        <li class="nav-menu-item active">
                            <a class="nav-menu-link" href="messages.php">
                                <span class="icon icon-messages"></span> Messages
                                <?php if ($unread_count > 0): ?>
                                    <span class="badge bg-warning ms-2"><?php echo $unread_count; ?></span>
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
                    <div class="main-content-inner wrap-dashboard-content">
                        <div class="button-show-hide show-mb">
                            <span class="body-1">Show Dashboard</span>
                        </div>
                        
                        <!-- Success Messages -->
                        <?php if (isset($_GET['read'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon icon-tick"></i> Message marked as read!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['deleted'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon icon-tick"></i> Message deleted successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Messages Stats -->
                        <div class="stats-header">
                            <h5 class="mb-4">💬 Messages Overview</h5>
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <h3 class="mb-1"><?php echo count($messages); ?></h3>
                                    <small>Total Messages</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3 class="mb-1"><?php echo $unread_count; ?></h3>
                                    <small>Unread Messages</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3 class="mb-1"><?php echo $today_count; ?></h3>
                                    <small>Messages Today</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-box-2 wd-listing">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="title">📨 Contact Messages</h6>
                                <?php if ($unread_count > 0): ?>
                                    <span class="badge bg-warning">
                                        <i class="icon icon-messages"></i> <?php echo $unread_count; ?> unread
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="wrap-table">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Contact Information</th>
                                                <th>Property Interest</th>
                                                <th>Message Preview</th>
                                                <th>Received</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($messages)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <div>
                                                        <i class="icon icon-messages text-muted mb-3" style="font-size: 3rem;"></i>
                                                        <h5>No messages yet</h5>
                                                        <p class="text-muted">Contact messages from property inquiries will appear here.</p>
                                                        <a href="../contact.php" class="tf-btn primary btn-sm">View Contact Page</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                                <?php foreach ($messages as $msg): ?>
                                                <tr class="message-card <?php echo !$msg['is_read'] ? 'unread-message' : ''; ?>">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avt-40 round me-3">
                                                                <img src="../images/avatar/avt-2.jpg" alt="avatar">
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">
                                                                    <?php echo htmlspecialchars($msg['name']); ?>
                                                                    <?php if (!$msg['is_read']): ?>
                                                                        <span class="badge bg-warning ms-1">New</span>
                                                                    <?php endif; ?>
                                                                </h6>
                                                                <p class="mb-0 small text-muted">
                                                                    <i class="icon icon-mail"></i> <?php echo htmlspecialchars($msg['email']); ?>
                                                                </p>
                                                                <?php if ($msg['phone']): ?>
                                                                    <p class="mb-0 small text-muted">
                                                                        <i class="icon icon-phone"></i> <?php echo htmlspecialchars($msg['phone']); ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if ($msg['property_title']): ?>
                                                            <div class="d-flex align-items-center">
                                                                <i class="icon icon-home text-primary me-2"></i>
                                                                <div>
                                                                    <a href="../property-details.php?id=<?php echo $msg['property_id']; ?>" class="text-decoration-none fw-bold">
                                                                        <?php echo htmlspecialchars($msg['property_title']); ?>
                                                                    </a>
                                                                    <br><small class="text-muted">Property Inquiry</small>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-dark">
                                                                <i class="icon icon-messages"></i> General Inquiry
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="message-preview">
                                                            <p class="mb-1"><?php echo htmlspecialchars(substr($msg['message'], 0, 100)); ?><?php if (strlen($msg['message']) > 100): ?>...<?php endif; ?></p>
                                                            <?php if (strlen($msg['message']) > 100): ?>
                                                                <button class="btn btn-link btn-sm p-0" onclick="showFullMessage('<?php echo addslashes($msg['message']); ?>')">
                                                                    Read Full Message
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted">
                                                        <?php echo date('M j, Y', strtotime($msg['created_at'])); ?>
                                                        <br><small><?php echo date('g:i A', strtotime($msg['created_at'])); ?></small>
                                                        <?php if (strtotime($msg['created_at']) > strtotime('-24 hours')): ?>
                                                            <span class="badge bg-success ms-1">Recent</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <?php if (!$msg['is_read']): ?>
                                                                <a href="?action=read&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-success" title="Mark as Read">
                                                                    <i class="icon icon-tick"></i>
                                                                </a>
                                                            <?php else: ?>
                                                                <span class="btn btn-sm btn-outline-secondary disabled" title="Already Read">
                                                                    <i class="icon icon-tick"></i>
                                                                </span>
                                                            <?php endif; ?>
                                                            <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="btn btn-sm btn-outline-primary" title="Reply via Email">
                                                                <i class="icon icon-mail"></i>
                                                            </a>
                                                            <a href="?action=delete&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                               onclick="return confirm('⚠️ Are you sure you want to delete this message? This action cannot be undone.')" title="Delete Message">
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

    <!-- Full Message Modal -->
    <div class="modal fade" id="fullMessageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Full Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="fullMessageContent"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugin.js"></script>
    <script src="../js/shortcodes.js"></script>
    <script src="../js/main.js"></script>
    
    <script>
        function showFullMessage(message) {
            document.getElementById('fullMessageContent').textContent = message;
            var modal = new bootstrap.Modal(document.getElementById('fullMessageModal'));
            modal.show();
        }
    </script>
</body>
</html>
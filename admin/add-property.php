<?php
require_once '../config/session.php';
require_once '../classes/Property.php';

requireAdmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'price' => $_POST['price'] ?? 0,
        'address' => $_POST['address'] ?? '',
        'bedrooms' => $_POST['bedrooms'] ?? 0,
        'bathrooms' => $_POST['bathrooms'] ?? 0,
        'area' => $_POST['area'] ?? 0,
        'property_type' => $_POST['property_type'] ?? 'apartment',
        'status' => $_POST['status'] ?? 'active',
        'image' => $_POST['image'] ?? 'images/home/house-1.jpg'
    ];
    
    if (!empty($data['title']) && !empty($data['address']) && $data['price'] > 0) {
        $property = new Property();
        if ($property->addProperty($data)) {
            $success = 'Property added successfully!';
        } else {
            $error = 'Failed to add property';
        }
    } else {
        $error = 'Please fill in all required fields';
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Add Property - Admin Panel</title>
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
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>
                        
                        <div class="widget-box-2">
                            <h6 class="title">Add New Property</h6>
                            <form method="POST" class="box-info-property">
                                <fieldset class="box box-fieldset">
                                    <label for="title">Property Title:<span>*</span></label>
                                    <input type="text" name="title" class="form-control style-1" required>
                                </fieldset>
                                
                                <fieldset class="box box-fieldset">
                                    <label for="description">Description:</label>
                                    <textarea name="description" class="form-control" rows="4"></textarea>
                                </fieldset>
                                
                                <div class="box grid-3 gap-30">
                                    <fieldset class="box-fieldset">
                                        <label for="price">Price:<span>*</span></label>
                                        <input type="number" name="price" class="form-control style-1" step="0.01" required>
                                    </fieldset>
                                    <fieldset class="box-fieldset">
                                        <label for="property_type">Property Type:<span>*</span></label>
                                        <select name="property_type" class="form-control style-1" required>
                                            <option value="apartment">Apartment</option>
                                            <option value="villa">Villa</option>
                                            <option value="studio">Studio</option>
                                            <option value="office">Office</option>
                                            <option value="townhouse">Townhouse</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="box-fieldset">
                                        <label for="status">Status:<span>*</span></label>
                                        <select name="status" class="form-control style-1" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="sold">Sold</option>
                                        </select>
                                    </fieldset>
                                </div>
                                
                                <fieldset class="box box-fieldset">
                                    <label for="address">Full Address:<span>*</span></label>
                                    <input type="text" name="address" class="form-control style-1" required>
                                </fieldset>
                                
                                <div class="box grid-3 gap-30">
                                    <fieldset class="box-fieldset">
                                        <label for="bedrooms">Bedrooms:</label>
                                        <input type="number" name="bedrooms" class="form-control style-1" min="0">
                                    </fieldset>
                                    <fieldset class="box-fieldset">
                                        <label for="bathrooms">Bathrooms:</label>
                                        <input type="number" name="bathrooms" class="form-control style-1" min="0">
                                    </fieldset>
                                    <fieldset class="box-fieldset">
                                        <label for="area">Area (SqFt):</label>
                                        <input type="number" name="area" class="form-control style-1" min="0">
                                    </fieldset>
                                </div>
                                
                                <fieldset class="box box-fieldset">
                                    <label for="image">Image Path:</label>
                                    <input type="text" name="image" class="form-control style-1" placeholder="images/home/house-1.jpg">
                                </fieldset>
                                
                                <button type="submit" class="tf-btn primary">Add Property</button>
                            </form>
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
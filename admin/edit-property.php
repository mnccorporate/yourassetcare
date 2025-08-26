<?php
require_once '../config/session.php';
require_once '../classes/Property.php';

requireAdmin();

$property_id = $_GET['id'] ?? 0;
$property = new Property();
$prop = $property->getPropertyById($property_id);

if (!$prop) {
    header('Location: properties.php');
    exit();
}

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
        'image' => $_POST['image'] ?? ''
    ];
    
    if (!empty($data['title']) && !empty($data['address']) && $data['price'] > 0) {
        if ($property->updateProperty($property_id, $data)) {
            $success = 'Property updated successfully! 🎉';
            $prop = $property->getPropertyById($property_id); // Refresh data
        } else {
            $error = 'Failed to update property. Please try again.';
        }
    } else {
        $error = 'Please fill in all required fields with valid data.';
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Edit Property - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../fonts/font-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    
    <link rel="shortcut icon" href="../images/logo/favicon.png">
    
    <style>
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .form-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-section h6 {
            color: #667eea;
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .required-field {
            border-left: 3px solid #dc3545;
        }
        .image-preview {
            max-width: 200px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .property-preview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
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
                    <div class="main-content-inner">
                        <div class="button-show-hide show-mb">
                            <span class="body-1">Show Dashboard</span>
                        </div>
                        
                        <!-- Header -->
                        <div class="form-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-2">✏️ Edit Property</h4>
                                    <p class="mb-0">Update property information and details</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="../property-details.php?id=<?php echo $property_id; ?>" class="tf-btn secondary">
                                        <i class="icon icon-eye"></i> Preview
                                    </a>
                                    <a href="properties.php" class="tf-btn secondary">
                                        <i class="icon icon-arr-l"></i> Back to Properties
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Current Property Preview -->
                        <div class="property-preview">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="../<?php echo htmlspecialchars($prop['image']); ?>" alt="property" class="img-fluid rounded">
                                </div>
                                <div class="col-md-10">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($prop['title']); ?></h5>
                                    <p class="text-muted mb-1">
                                        <i class="icon icon-mapPin"></i> <?php echo htmlspecialchars($prop['address']); ?>
                                    </p>
                                    <div class="d-flex gap-3">
                                        <span class="badge bg-success">$<?php echo number_format($prop['price'], 2); ?></span>
                                        <span class="badge bg-primary"><?php echo ucfirst($prop['property_type']); ?></span>
                                        <span class="badge bg-<?php echo $prop['status'] === 'active' ? 'success' : 'secondary'; ?>"><?php echo ucfirst($prop['status']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="icon icon-close2"></i> <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="icon icon-tick"></i> <?php echo htmlspecialchars($success); ?>
                                <div class="mt-2">
                                    <a href="properties.php" class="btn btn-success btn-sm me-2">Back to Properties</a>
                                    <a href="../property-details.php?id=<?php echo $property_id; ?>" class="btn btn-outline-success btn-sm">View Property</a>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="property-form">
                            <!-- Basic Information -->
                            <div class="form-section">
                                <h6><i class="icon icon-home"></i> Basic Information</h6>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <fieldset class="box box-fieldset required-field">
                                            <label for="title">Property Title:<span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control style-1" 
                                                   value="<?php echo htmlspecialchars($prop['title']); ?>" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset required-field">
                                            <label for="status">Listing Status:<span class="text-danger">*</span></label>
                                            <select name="status" class="form-control style-1" required>
                                                <option value="active" <?php echo $prop['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="inactive" <?php echo $prop['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="sold" <?php echo $prop['status'] === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                
                                <fieldset class="box box-fieldset">
                                    <label for="description">Property Description:</label>
                                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($prop['description']); ?></textarea>
                                </fieldset>
                            </div>

                            <!-- Pricing & Type -->
                            <div class="form-section">
                                <h6><i class="icon icon-star"></i> Pricing & Classification</h6>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <fieldset class="box box-fieldset required-field">
                                            <label for="price">Property Price:<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="price" class="form-control style-1" 
                                                       value="<?php echo $prop['price']; ?>" step="0.01" required>
                                            </div>
                                            <?php if ($prop['area'] > 0): ?>
                                                <small class="text-muted">Current: $<?php echo number_format($prop['price'] / $prop['area'], 2); ?> per sqft</small>
                                            <?php endif; ?>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-6">
                                        <fieldset class="box box-fieldset required-field">
                                            <label for="property_type">Property Type:<span class="text-danger">*</span></label>
                                            <select name="property_type" class="form-control style-1" required>
                                                <option value="apartment" <?php echo $prop['property_type'] === 'apartment' ? 'selected' : ''; ?>>🏢 Apartment</option>
                                                <option value="villa" <?php echo $prop['property_type'] === 'villa' ? 'selected' : ''; ?>>🏡 Villa</option>
                                                <option value="studio" <?php echo $prop['property_type'] === 'studio' ? 'selected' : ''; ?>>🏠 Studio</option>
                                                <option value="office" <?php echo $prop['property_type'] === 'office' ? 'selected' : ''; ?>>🏢 Office</option>
                                                <option value="townhouse" <?php echo $prop['property_type'] === 'townhouse' ? 'selected' : ''; ?>>🏘️ Townhouse</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="form-section">
                                <h6><i class="icon icon-mapPin"></i> Location Details</h6>
                                <fieldset class="box box-fieldset required-field">
                                    <label for="address">Full Address:<span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control style-1" 
                                           value="<?php echo htmlspecialchars($prop['address']); ?>" required>
                                </fieldset>
                            </div>

                            <!-- Property Features -->
                            <div class="form-section">
                                <h6><i class="icon icon-ruler"></i> Property Features</h6>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset">
                                            <label for="bedrooms">Number of Bedrooms:</label>
                                            <input type="number" name="bedrooms" class="form-control style-1" 
                                                   value="<?php echo $prop['bedrooms']; ?>" min="0">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset">
                                            <label for="bathrooms">Number of Bathrooms:</label>
                                            <input type="number" name="bathrooms" class="form-control style-1" 
                                                   value="<?php echo $prop['bathrooms']; ?>" min="0">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset">
                                            <label for="area">Area (Square Feet):</label>
                                            <input type="number" name="area" class="form-control style-1" 
                                                   value="<?php echo $prop['area']; ?>" min="0">
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="form-section">
                                <h6><i class="icon icon-images"></i> Property Image</h6>
                                <fieldset class="box box-fieldset">
                                    <label for="image">Image Path:</label>
                                    <select name="image" class="form-control style-1" onchange="previewImage(this.value)">
                                        <option value="images/home/house-1.jpg" <?php echo $prop['image'] === 'images/home/house-1.jpg' ? 'selected' : ''; ?>>House 1</option>
                                        <option value="images/home/house-2.jpg" <?php echo $prop['image'] === 'images/home/house-2.jpg' ? 'selected' : ''; ?>>House 2</option>
                                        <option value="images/home/house-3.jpg" <?php echo $prop['image'] === 'images/home/house-3.jpg' ? 'selected' : ''; ?>>House 3</option>
                                        <option value="images/home/house-4.jpg" <?php echo $prop['image'] === 'images/home/house-4.jpg' ? 'selected' : ''; ?>>House 4</option>
                                        <option value="images/home/house-5.jpg" <?php echo $prop['image'] === 'images/home/house-5.jpg' ? 'selected' : ''; ?>>House 5</option>
                                        <option value="images/home/house-6.jpg" <?php echo $prop['image'] === 'images/home/house-6.jpg' ? 'selected' : ''; ?>>House 6</option>
                                        <option value="images/home/house-7.jpg" <?php echo $prop['image'] === 'images/home/house-7.jpg' ? 'selected' : ''; ?>>House 7</option>
                                        <option value="images/home/house-8.jpg" <?php echo $prop['image'] === 'images/home/house-8.jpg' ? 'selected' : ''; ?>>House 8</option>
                                    </select>
                                    <img id="imagePreview" src="../<?php echo htmlspecialchars($prop['image']); ?>" 
                                         alt="Preview" class="image-preview">
                                </fieldset>
                            </div>

                            <!-- Property Metadata -->
                            <div class="form-section">
                                <h6><i class="icon icon-calendar"></i> Property Metadata</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <strong>Property ID:</strong> #<?php echo $prop['id']; ?>
                                        </div>
                                        <div class="info-item">
                                            <strong>Created:</strong> <?php echo date('F j, Y g:i A', strtotime($prop['created_at'])); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <strong>Last Updated:</strong> <?php echo date('F j, Y g:i A', strtotime($prop['updated_at'])); ?>
                                        </div>
                                        <?php if ($prop['area'] > 0): ?>
                                            <div class="info-item">
                                                <strong>Price per SqFt:</strong> $<?php echo number_format($prop['price'] / $prop['area'], 2); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-section">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="properties.php" class="tf-btn secondary">
                                        <i class="icon icon-arr-l"></i> Cancel
                                    </a>
                                    <a href="../property-details.php?id=<?php echo $property_id; ?>" class="tf-btn secondary">
                                        <i class="icon icon-eye"></i> Preview Property
                                    </a>
                                    <button type="submit" class="tf-btn primary">
                                        <i class="icon icon-tick"></i> Update Property
                                    </button>
                                </div>
                            </div>
                        </form>
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
    
    <script>
        function previewImage(imagePath) {
            document.getElementById('imagePreview').src = '../' + imagePath;
        }
    </script>
</body>
</html>
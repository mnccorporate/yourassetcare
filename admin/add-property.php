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
            $success = 'Property added successfully! 🎉';
            // Clear form data
            $data = [
                'title' => '',
                'description' => '',
                'price' => '',
                'address' => '',
                'bedrooms' => 0,
                'bathrooms' => 0,
                'area' => 0,
                'property_type' => 'apartment',
                'status' => 'active',
                'image' => 'images/home/house-1.jpg'
            ];
        } else {
            $error = 'Failed to add property. Please try again.';
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
    <title>Add Property - Admin Panel</title>
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
                        <li class="nav-menu-item">
                            <a class="nav-menu-link" href="messages.php">
                                <span class="icon icon-messages"></span> Messages
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
                        
                        <!-- Header -->
                        <div class="form-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-2">🏠 Add New Property</h4>
                                    <p class="mb-0">Create a new property listing for your platform</p>
                                </div>
                                <a href="properties.php" class="tf-btn secondary">
                                    <i class="icon icon-arr-l"></i> Back to Properties
                                </a>
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
                                    <a href="properties.php" class="btn btn-success btn-sm me-2">View All Properties</a>
                                    <a href="add-property.php" class="btn btn-outline-success btn-sm">Add Another Property</a>
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
                                                   value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" 
                                                   placeholder="e.g., Luxury Villa with Ocean View" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset required-field">
                                            <label for="status">Listing Status:<span class="text-danger">*</span></label>
                                            <select name="status" class="form-control style-1" required>
                                                <option value="active" <?php echo ($data['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="inactive" <?php echo ($data['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="sold" <?php echo ($data['status'] ?? '') === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                
                                <fieldset class="box box-fieldset">
                                    <label for="description">Property Description:</label>
                                    <textarea name="description" class="form-control" rows="4" 
                                              placeholder="Describe the property features, amenities, and unique selling points..."><?php echo htmlspecialchars($data['description'] ?? ''); ?></textarea>
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
                                                       value="<?php echo $data['price'] ?? ''; ?>" 
                                                       step="0.01" min="0" placeholder="0.00" required>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-6">
                                        <fieldset class="box box-fieldset required-field">
                                            <label for="property_type">Property Type:<span class="text-danger">*</span></label>
                                            <select name="property_type" class="form-control style-1" required>
                                                <option value="apartment" <?php echo ($data['property_type'] ?? '') === 'apartment' ? 'selected' : ''; ?>>🏢 Apartment</option>
                                                <option value="villa" <?php echo ($data['property_type'] ?? '') === 'villa' ? 'selected' : ''; ?>>🏡 Villa</option>
                                                <option value="studio" <?php echo ($data['property_type'] ?? '') === 'studio' ? 'selected' : ''; ?>>🏠 Studio</option>
                                                <option value="office" <?php echo ($data['property_type'] ?? '') === 'office' ? 'selected' : ''; ?>>🏢 Office</option>
                                                <option value="townhouse" <?php echo ($data['property_type'] ?? '') === 'townhouse' ? 'selected' : ''; ?>>🏘️ Townhouse</option>
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
                                           value="<?php echo htmlspecialchars($data['address'] ?? ''); ?>" 
                                           placeholder="e.g., 123 Main Street, City, State, ZIP Code" required>
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
                                                   value="<?php echo $data['bedrooms'] ?? 0; ?>" min="0" max="20">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset">
                                            <label for="bathrooms">Number of Bathrooms:</label>
                                            <input type="number" name="bathrooms" class="form-control style-1" 
                                                   value="<?php echo $data['bathrooms'] ?? 0; ?>" min="0" max="20">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset class="box box-fieldset">
                                            <label for="area">Area (Square Feet):</label>
                                            <input type="number" name="area" class="form-control style-1" 
                                                   value="<?php echo $data['area'] ?? 0; ?>" min="0" placeholder="e.g., 1200">
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
                                        <option value="images/home/house-1.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-1.jpg' ? 'selected' : ''; ?>>House 1</option>
                                        <option value="images/home/house-2.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-2.jpg' ? 'selected' : ''; ?>>House 2</option>
                                        <option value="images/home/house-3.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-3.jpg' ? 'selected' : ''; ?>>House 3</option>
                                        <option value="images/home/house-4.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-4.jpg' ? 'selected' : ''; ?>>House 4</option>
                                        <option value="images/home/house-5.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-5.jpg' ? 'selected' : ''; ?>>House 5</option>
                                        <option value="images/home/house-6.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-6.jpg' ? 'selected' : ''; ?>>House 6</option>
                                        <option value="images/home/house-7.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-7.jpg' ? 'selected' : ''; ?>>House 7</option>
                                        <option value="images/home/house-8.jpg" <?php echo ($data['image'] ?? '') === 'images/home/house-8.jpg' ? 'selected' : ''; ?>>House 8</option>
                                    </select>
                                    <img id="imagePreview" src="../<?php echo $data['image'] ?? 'images/home/house-1.jpg'; ?>" 
                                         alt="Preview" class="image-preview">
                                </fieldset>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-section">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="properties.php" class="tf-btn secondary">
                                        <i class="icon icon-arr-l"></i> Cancel
                                    </a>
                                    <button type="reset" class="tf-btn secondary">
                                        <i class="icon icon-refresh"></i> Reset Form
                                    </button>
                                    <button type="submit" class="tf-btn primary">
                                        <i class="icon icon-plus"></i> Add Property
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
        
        // Auto-calculate price per sqft
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.querySelector('input[name="price"]');
            const areaInput = document.querySelector('input[name="area"]');
            
            function updatePricePerSqft() {
                const price = parseFloat(priceInput.value) || 0;
                const area = parseFloat(areaInput.value) || 0;
                
                if (price > 0 && area > 0) {
                    const pricePerSqft = (price / area).toFixed(2);
                    // You could display this somewhere if needed
                }
            }
            
            priceInput.addEventListener('input', updatePricePerSqft);
            areaInput.addEventListener('input', updatePricePerSqft);
        });
    </script>
</body>
</html>
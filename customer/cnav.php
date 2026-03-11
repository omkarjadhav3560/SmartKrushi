<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current file name for Active Menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);

/**
 * LOGIC TO FETCH NAME:
 * Since this nav is included in cprofile.php, it will use the $name variable 
 * defined there. We also add a fallback for other pages.
 */
$displayName = "Profile"; // Default fallback

if (isset($name) && !empty($name)) {
    $displayName = $name; // Use the $name variable from cprofile.php if it exists
} elseif (isset($_SESSION['customer_login_user'])) {
    // If $name isn't defined yet (on other pages), displayName stays 'Profile' 
    // or you can add a small query here to fetch it globally.
    $displayName = "My Account"; 
}
?>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .navbar-custom {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 12px 0;
    }

    .navbar-brand {
        font-weight: 800;
        font-size: 1.4rem;
        text-transform: uppercase;
        color: white !important;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.95) !important;
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0 4px;
        padding: 8px 16px !important;
        border-radius: 50px;
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff !important;
    }

    /* Active Pill Style */
    .nav-link.active-page {
        background-color: #fff !important;
        color: #2dce89 !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
    }
    
    .nav-link.active-page i {
        color: #2dce89 !important;
    }

    .user-profile-nav {
        border: 1px solid rgba(255,255,255,0.4);
        background: rgba(255,255,255,0.1);
    }

    .btn-logout {
        background-color: #f5365c;
        border: none;
        border-radius: 5px;
        font-weight: 700;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">
            <i class="fas fa-leaf mr-2"></i> SmartKrushi
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbar_global">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a href="cbuy_crops.php" class="nav-link <?php echo ($current_page == 'cbuy_crops.php') ? 'active-page' : ''; ?>">
                        <i class="fas fa-shopping-basket"></i> Buy Crops
                    </a>
                </li>

                <li class="nav-item">
                    <a href="cstock_crop.php" class="nav-link <?php echo ($current_page == 'cstock_crop.php') ? 'active-page' : ''; ?>">
                        <i class="fas fa-chart-bar"></i> Market Stock
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="corder_history.php" class="nav-link <?php echo ($current_page == 'corder_history.php') ? 'active-page' : ''; ?>">
                        <i class="fas fa-list-alt"></i> My Orders
                    </a>
                </li>

                <li class="nav-item">
                    <a href="cprofile.php" class="nav-link user-profile-nav <?php echo ($current_page == 'cprofile.php') ? 'active-page' : ''; ?>">
                        <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($displayName); ?>
                    </a>
                </li>

                <li class="nav-item ml-lg-3">
                    <a href="clogout.php" class="nav-link btn-logout text-white px-3 shadow-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    .navbar-custom {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 0.7rem 1rem;
    }

    .navbar-brand {
        font-weight: 800;
        font-size: 1.5rem;
        color: white !important;
        text-transform: uppercase;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: white !important;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 5px;
        border-radius: 5px;
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .nav-item.active .nav-link {
        background: white !important;
        color: #2dce89 !important;
    }

    .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item:hover {
        background-color: #f6f9fc;
        color: #2dce89;
        padding-left: 25px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-leaf mr-2"></i> SmartKrushi
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbar_global">
            <ul class="navbar-nav ml-auto align-items-center">
                
                <li class="nav-item dropdown <?php if(in_array($current_page, ['ftradecrops.php', 'fstock_crop.php', 'fselling_history.php', 'fmanage_orders.php'])) echo 'active'; ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="tradeDrop" data-toggle="dropdown">
                        <i class="fas fa-exchange-alt mr-1"></i> Trade
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="ftradecrops.php"><i class="fas fa-plus-circle text-primary"></i> Trade Crops</a>
                        <a class="dropdown-item" href="fstock_crop.php"><i class="fas fa-boxes text-info"></i> Crop Stocks</a>
                        <a class="dropdown-item" href="fselling_history.php"><i class="fas fa-history text-muted"></i> Selling History</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="fmanage_orders.php"><i class="fas fa-box-open text-success"></i> Fulfill Orders</a>
                    </div>
                </li>

                <li class="nav-item dropdown <?php if(in_array($current_page, ['fchatgpt.php', 'fweather_prediction.php', 'fnewsfeed.php'])) echo 'active'; ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="toolsDrop" data-toggle="dropdown">
                        <i class="fas fa-tools mr-1"></i> Tools
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="fchatgpt.php"><i class="fas fa-robot text-dark"></i> AI Assistant</a>
                        <a class="dropdown-item" href="fweather_prediction.php"><i class="fas fa-cloud-sun text-warning"></i> Weather</a>
                        <a class="dropdown-item" href="fnewsfeed.php"><i class="fas fa-newspaper text-primary"></i> News</a>
                    </div>
                </li>

                <li class="nav-item <?php if($current_page == 'fprofile.php') echo 'active'; ?>">
                    <a href="fprofile.php" class="nav-link">
                        <i class="fas fa-user-circle mr-1"></i> <?php echo isset($para2) ? $para2 : 'Farmer'; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="flogout.php" class="btn btn-white btn-sm px-3 ml-lg-3 text-danger font-weight-bold shadow-sm">
                        <i class="fas fa-power-off"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
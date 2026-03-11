<?php
session_start();
require('../sql.php'); 

if(!isset($_SESSION['admin_login_user'])){
    header("location: ../index.php");
    exit();
}

$user = $_SESSION['admin_login_user'];
$query4 = "SELECT * from admin where admin_name ='$user'";
$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);
$para1 = $row4['admin_id'];
$para2 = $row4['admin_name'];

// --- NEW: Fetch Stats for Dashboard ---
$count_farmers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM farmerlogin"));
$count_customers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM custlogin"));
$count_trades = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM farmer_crops_trade WHERE Crop_quantity > 0"));
?>

<!DOCTYPE html>
<html lang="en">
<?php require ('aheader.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .icon-shape {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .admin-profile-card {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
    }
</style>

<body class="bg-light">
    <?php require ('anav.php'); ?>

    <div class="header pb-8 pt-5 pt-md-8" style="background: linear-gradient(87deg, #11cdef 0, #1171ef 100%); min-height: 400px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h1 class="display-4 text-white text-center text-uppercase" style="letter-spacing: 2px;">Admin Management Console</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card stat-card bg-gradient-danger text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase mb-0 text-white-50">Total Farmers</h5>
                                    <span class="h2 font-weight-bold mb-0"><?php echo $count_farmers; ?></span>
                                </div>
                                <div class="icon-shape"><i class="fas fa-tractor"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card stat-card bg-gradient-warning text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase mb-0 text-white-50">Total Customers</h5>
                                    <span class="h2 font-weight-bold mb-0"><?php echo $count_customers; ?></span>
                                </div>
                                <div class="icon-shape"><i class="fas fa-users"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card stat-card bg-gradient-success text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase mb-0 text-white-50">Live Trades</h5>
                                    <span class="h2 font-weight-bold mb-0"><?php echo $count_trades; ?></span>
                                </div>
                                <div class="icon-shape"><i class="fas fa-leaf"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 mb-5">
                <div class="card card-profile shadow stat-card border-0">
                    <div class="card-body pt-0 pt-md-4 admin-profile-card text-white rounded">
                        <div class="text-center mt-3">
                            <img src="../assets/img/admin.png" class="rounded-circle shadow mb-4" width="120">
                            <h3>Welcome, <?php echo $para2 ?></h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>System Administrator
                            </div>
                            <div class="h6 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>Admin ID: #00<?php echo $para1 ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Administrative Privileges</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i> Full Database Access
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i> Customer Modification
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i> Farmer Supply Management
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i> Detailed Sales Reporting
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center py-3">
                            <a href="asales_report.php" class="btn btn-primary px-5 shadow rounded-pill">View Full Sales Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require("footer.php");?>
</body>
</html>
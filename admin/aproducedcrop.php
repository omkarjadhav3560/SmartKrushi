<?php
session_start();
require('../sql.php'); 

// 1. Admin Session Security
if(!isset($_SESSION['admin_login_user'])){
    header("location: ../index.php");
    exit();
}

$user = $_SESSION['admin_login_user'];
$query4 = "SELECT * from admin where admin_name =?";
$stmt_admin = $conn->prepare($query4);
$stmt_admin->bind_param("s", $user);
$stmt_admin->execute();
$row4 = $stmt_admin->get_result()->fetch_assoc();

// 2. COLUMN DISCOVERY
$check_cols = mysqli_query($conn, "SHOW COLUMNS FROM farmerlogin LIKE 'f%name%'");
$col_row = mysqli_fetch_assoc($check_cols);
$name_column = $col_row ? $col_row['Field'] : 'farmer_id'; 

// 3. SUMMARY SQL: Updated to show only Quintals
$summary_sql = "SELECT Trade_crop, (SUM(Crop_quantity)/100) as total_q 
                FROM farmer_crops_trade 
                WHERE Crop_quantity > 0 
                GROUP BY Trade_crop";
$summary_result = mysqli_query($conn, $summary_sql);

// 4. INDIVIDUAL LISTINGS SQL: Updated for Quintals
$sql = "SELECT 
            t.Trade_id, t.Trade_crop, (t.Crop_quantity / 100) as quintal, 
            t.crop_image, t.costperkg, f.$name_column as farmer_display_name 
        FROM farmer_crops_trade t
        LEFT JOIN farmerlogin f ON t.farmer_fkid = f.farmer_id
        WHERE t.Crop_quantity > 0 
        ORDER BY t.Trade_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<?php require ('aheader.php'); ?>

<style>
    body { background-color: #f4f6f9; font-family: 'Poppins', sans-serif; }
    .admin-header-section {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%);
        padding: 60px 0; margin-bottom: 30px; color: white;
        text-align: center; border-radius: 0 0 40px 40px;
    }
    .summary-card {
        background: white; border-radius: 15px; border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 40px; overflow: hidden;
    }
    .summary-table thead { background-color: #f8f9fe; color: #8898aa; text-transform: uppercase; font-size: 0.8rem; }
    .crop-card {
        background: white; border-radius: 20px; border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s ease;
        overflow: hidden; height: 100%; display: flex; flex-direction: column; position: relative;
    }
    .card-img-wrap { height: 180px; position: relative; overflow: hidden; cursor: pointer; }
    .card-img-top { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .quintal-badge {
        position: absolute; top: 15px; right: 15px; background: #2dce89; color: white;
        padding: 6px 14px; border-radius: 30px; font-size: 0.85rem; font-weight: 700; z-index: 2;
    }
    .crop-name { font-size: 1.25rem; font-weight: 700; color: #32325d; text-transform: uppercase; }
    .stats-container {
        display: flex; justify-content: space-between; background: #f8f9fa;
        padding: 12px; border-radius: 12px; border: 1px solid #eef1f3;
    }
    .stat-label { font-size: 0.65rem; text-transform: uppercase; color: #8898aa; }
    .stat-value { font-size: 0.95rem; font-weight: 700; color: #32325d; }
</style>

<body>
<?php require ('anav.php'); ?>

<div class="admin-header-section">
    <div class="container">
        <h1 class="text-white font-weight-bold">MARKET INVENTORY SYSTEM</h1>
        <p class="lead">Stock measured in Quintals (1 Q = 100 KG)</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3 text-default"><i class="fas fa-chart-pie mr-2"></i> Total Stock Inventory (In Quintals)</h4>
            <div class="summary-card shadow">
                <div class="table-responsive">
                    <table class="table summary-table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="pl-4">Crop Name</th>
                                <th>Total Stock Available</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($s_row = mysqli_fetch_assoc($summary_result)) { ?>
                            <tr>
                                <td class="pl-4 font-weight-bold text-dark"><?php echo $s_row['Trade_crop']; ?></td>
                                <td><span class="badge badge-success" style="font-size: 0.9rem;"><?php echo number_format($s_row['total_q'], 2); ?> Q</span></td>
                                <td><span class="badge badge-dot mr-4"><i class="bg-success"></i> <span class="status">Active Stock</span></span></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <h4 class="mb-4 text-default"><i class="fas fa-list mr-2"></i> Individual Seller Posts</h4>
    <div class="row">
        <?php
        if(mysqli_num_rows($result) > 0) {
            $i = 0;
            while($row = mysqli_fetch_assoc($result)) {
                $i++;
                $imgSource = "../farmer/crop_images/" . $row['crop_image'];
                if(empty($row['crop_image']) || !file_exists($imgSource)) { $imgSource = "../assets/img/agri.png"; }
        ?>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="crop-card shadow">
                <div class="card-img-wrap" data-toggle="modal" data-target="#modal<?php echo $i; ?>">
                    <img src="<?php echo $imgSource; ?>" class="card-img-top" alt="Crop">
                    <div class="quintal-badge"><?php echo number_format($row['quintal'], 2); ?> Q</div>
                </div>

                <div class="card-body">
                    <div class="crop-name"><?php echo $row['Trade_crop']; ?></div>
                    <span class="text-muted small d-block mb-3">Seller: <b><?php echo $row['farmer_display_name']; ?></b></span>

                    <div class="stats-container">
                        <div>
                            <div class="stat-label">Stock Weight</div>
                            <div class="stat-value text-success"><?php echo number_format($row['quintal'], 2); ?> Quintals</div>
                        </div>
                        <div class="text-right">
                            <div class="stat-label">ID</div>
                            <div class="stat-value">#<?php echo $row['Trade_id']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <button type="button" class="btn-close-modal" data-dismiss="modal">&times;</button>
                    <div class="modal-body p-0 text-center">
                        <img src="<?php echo $imgSource; ?>" class="img-fluid" style="max-height: 80vh;">
                    </div>
                </div>
            </div>
        </div>

        <?php } } else { echo "<div class='col-12 text-center'><p>No listings found.</p></div>"; } ?>
    </div>
</div>

<?php require("footer.php");?>
</body>
</html>
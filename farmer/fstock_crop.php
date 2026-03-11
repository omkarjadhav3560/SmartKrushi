<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

// 1. Security Check
if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// 2. Get User Info
if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query4 = "SELECT * from farmerlogin where email='$user_check'";
} else {
    $query4 = "SELECT * from farmerlogin where phone_no='$user_check'";
}

$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);

if($row4 && isset($row4['farmer_id'])) {
    $para1 = $row4['farmer_id'];
    $para2 = $row4['farmer_name'];
} else {
    header("location: flogin.php");
    exit();
}

// 3. DELETE LOGIC
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['crop'])) {
    $crop_to_delete = mysqli_real_escape_string($conn, urldecode($_GET['crop']));
    
    $delete_sql = "DELETE FROM farmer_crops_trade WHERE farmer_fkid = '$para1' AND Trade_crop = '$crop_to_delete'";
    
    if(mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Stock deleted successfully.'); window.location='fstock_crop.php';</script>";
    } else {
        echo "<script>alert('Error deleting stock. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('fheader.php'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fe;
        }
        .stock-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            padding: 5rem 0 8rem 0;
            position: relative;
            color: white;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            margin-bottom: -4rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .crop-card {
            border: none;
            border-radius: 15px;
            background: #fff;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }
        .crop-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        .img-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .badge-stock {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            color: #11998e;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
        }
        .card-content {
            padding: 20px;
        }
        .crop-title {
            font-weight: 700;
            color: #333;
            font-size: 1.25rem;
            text-transform: capitalize;
            margin-bottom: 5px;
        }
        .crop-price {
            color: #28a745;
            font-weight: 700;
            font-size: 1.3rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 15px 0;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            font-size: 0.85rem;
        }
        .info-label {
            color: #8898aa;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        .info-value {
            color: #525f7f;
            font-weight: 600;
        }
        .btn-view {
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            background: #e8f5e9;
            color: #1b5e20;
            border: none;
            transition: 0.2s;
            width: 100%;
        }
        .btn-view:hover {
            background: #11998e;
            color: white;
        }
        .btn-delete {
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            background: #ffebee;
            color: #c62828;
            border: none;
            transition: 0.2s;
            width: 100%;
        }
        .btn-delete:hover {
            background: #c62828;
            color: white;
        }
        .btn-add-new {
            background: white;
            color: #11998e;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        
        /* New styling for description in modal */
        .desc-box {
            background: #f4f6f9;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #28a745;
            text-align: left;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <?php include ('fnav.php'); ?>

    <div class="stock-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="font-weight-bold"><i class="fas fa-warehouse mr-2"></i> Inventory Manager</h1>
                    <p class="mb-0" style="opacity: 0.9;">Overview of your agricultural produce currently listed for trade.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <a href="ftradecrops.php" class="btn btn-add-new">
                        <i class="fas fa-plus-circle mr-1"></i> List New Crop
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px; z-index: 10;">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted font-weight-bold">
                                <i class="fas fa-user-circle text-success mr-2"></i> Account: <?php echo $para2; ?>
                            </span>
                            <span class="badge badge-success px-3 py-2 badge-pill">Active Seller</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php 
            // UPDATED SQL: Added MAX(crop_description) to fetch the text
            $sql = "SELECT 
                        Trade_crop, 
                        MAX(crop_image) as crop_image, 
                        SUM(Crop_quantity) as Total_Quantity, 
                        MIN(costperkg) as costperkg, 
                        MAX(msp) as msp, 
                        MAX(Trade_id) as Trade_id,
                        MAX(crop_description) as crop_description
                    FROM farmer_crops_trade 
                    WHERE farmer_fkid = '$para1' AND Crop_quantity > 0 
                    GROUP BY Trade_crop
                    ORDER BY Trade_id DESC"; 

            $query = mysqli_query($conn, $sql);

            if(mysqli_num_rows($query) > 0){
                while($res = mysqli_fetch_array($query)){
                    
                    $tradeID = $res['Trade_id'];
                    $imgName = $res['crop_image'];
                    $imgSource = "crop_images/" . $imgName;
                    $description = $res['crop_description']; // Get description
                    
                    if(empty($imgName) || !file_exists($imgSource)) {
                        $imgSource = "../assets/img/agri.png"; 
                    }
            ?>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="crop-card">
                    <div class="img-wrapper" data-toggle="modal" data-target="#imageModal<?php echo $tradeID; ?>" style="cursor: pointer;">
                        <img src="<?php echo $imgSource; ?>" alt="<?php echo $res['Trade_crop']; ?>">
                        <div class="badge-stock"><i class="fas fa-check"></i> In Stock</div>
                    </div>

                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="crop-title"><?php echo $res['Trade_crop']; ?></h5>
                                <div class="crop-price">₹<?php echo $res['costperkg']; ?> <span style="font-size: 0.8rem; color: #888; font-weight: 400;">/ Q</span></div>
                            </div>
                            <div class="text-right">
                                <i class="fas fa-leaf text-success fa-2x opacity-50"></i>
                            </div>
                        </div>

                        <div class="info-grid">
                            <div class="info-item border-right">
                                <span class="info-label"><i class="fas fa-weight-hanging mr-1"></i> Quantity</span>
                                <span class="info-value text-dark"><?php echo $res['Total_Quantity']; ?> Q</span>
                            </div>
                            <div class="info-item pl-3">
                                <span class="info-label"><i class="fas fa-tag mr-1"></i> Govt MSP</span>
                                <span class="info-value text-warning">₹<?php echo $res['msp']; ?>/Q</span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6 pr-1">
                                <button class="btn btn-view" data-toggle="modal" data-target="#imageModal<?php echo $tradeID; ?>">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                            </div>
                            <div class="col-6 pl-1">
                                <a href="fstock_crop.php?action=delete&crop=<?php echo urlencode($res['Trade_crop']); ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Are you sure?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imageModal<?php echo $tradeID; ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content border-0">
                  <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold text-uppercase"><?php echo $res['Trade_crop']; ?> Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                             <img src="<?php echo $imgSource; ?>" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-success mt-2">Crop Information:</h6>
                            <div class="desc-box">
                                <?php echo !empty($description) ? nl2br(htmlspecialchars($description)) : "No description provided for this stock."; ?>
                            </div>
                            <hr>
                            <p class="small text-muted mb-1">Stock ID: #<?php echo $tradeID; ?></p>
                            <p class="small text-muted">Quality: Guaranteed Fresh</p>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php 
                }
            } else {
                echo "
                <div class='col-12 text-center py-5'>
                    <div class='card border-0 bg-transparent'>
                        <div class='card-body'>
                            <img src='https://cdn-icons-png.flaticon.com/512/7486/7486744.png' width='120' style='opacity: 0.6;'>
                            <h3 class='text-muted mt-3 font-weight-bold'>No Crops Listed Yet</h3>
                            <p class='text-muted mb-4'>Start trading by adding your first crop to the market.</p>
                            <a href='ftradecrops.php' class='btn btn-success px-4 py-2 shadow'>
                                <i class='fas fa-plus'></i> Add Crop Now
                            </a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div> 
    </div>

    <?php require("footer.php");?>
</body>   
</html>
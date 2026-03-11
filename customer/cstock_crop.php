<?php
include ('csession.php');
include ('../sql.php');

ini_set('memory_limit', '-1');

if(!isset($_SESSION['customer_login_user'])){
    header("location: ../index.php");
    exit();
}

$user_check = $_SESSION['customer_login_user'];
if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query4 = "SELECT * from custlogin where email='$user_check'";
} else {
    $query4 = "SELECT * from custlogin where phone_no='$user_check'";
}
$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);

if(!$row4) {
    header("location: clogin.php");
    exit();
}

// --- SQL UPDATED: Added MAX(crop_description) ---
$sql = "SELECT Trade_crop, 
               SUM(Crop_quantity) as total_quantity, 
               MIN(costperkg) as start_price,
               MAX(crop_image) as sample_image,
               MAX(Trade_id) as Trade_id,
               MAX(crop_description) as crop_desc, 
               COUNT(DISTINCT farmer_fkid) as seller_count 
        FROM farmer_crops_trade 
        WHERE Crop_quantity > 0 
        GROUP BY Trade_crop 
        ORDER BY total_quantity DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<?php include ('cheader.php'); ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    body { background-color: #f0f3f8; font-family: 'Poppins', sans-serif; }
    .header-section { background: white; padding: 40px 0; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .page-title { text-align: center; margin: 0; font-weight: 700; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px; }
    
    /* CARD DESIGN */
    .crop-card {
        background: white; border-radius: 20px; border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: all 0.3s ease;
        overflow: hidden; height: 100%; display: flex; flex-direction: column;
    }
    .crop-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }

    .card-img-wrap { height: 200px; width: 100%; position: relative; overflow: hidden; cursor: pointer; }
    .card-img-top { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .crop-card:hover .card-img-top { transform: scale(1.1); }

    /* NEW: Description Styling */
    .crop-desc-preview {
        font-size: 0.82rem;
        color: #6c757d;
        margin: 10px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limits text to 2 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.4em;
    }

    .stock-badge {
        position: absolute; top: 15px; right: 15px; background: rgba(255, 255, 255, 0.95);
        padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;
        color: #2dce89; box-shadow: 0 2px 8px rgba(0,0,0,0.1); z-index: 2;
    }

    .card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
    .crop-name { font-size: 1.2rem; font-weight: 700; color: #333; text-transform: capitalize; }
    
    .price-block {
        margin-top: auto; display: flex; justify-content: space-between; align-items: center;
        background: #f8f9fa; padding: 10px; border-radius: 12px; margin-bottom: 15px;
    }
    .price-val { font-size: 1.1rem; font-weight: 700; color: #2dce89; }

    .btn-action {
        width: 100%; padding: 10px; border-radius: 12px; background: #32325d;
        color: white; font-weight: 600; text-align: center; display: block; transition: 0.3s;
    }
    .btn-action:hover { background: #2dce89; color: white; text-decoration: none; }
</style>

<body>
<?php include ('cnav.php'); ?>

<div class="header-section">
    <div class="container text-center">
        <h2 class="page-title">Market Overview</h2>
        <p class="text-muted">Direct from Farm to Your Doorstep</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <?php
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $tradeID = $row['Trade_id'];
                $imgName = $row['sample_image'];
                $imgSource = "../farmer/crop_images/" . $imgName;
                
                if(empty($imgName) || !file_exists($imgSource)) { 
                    $imgSource = "../assets/img/agri.png"; 
                }
                
                // Handle empty descriptions
                $description = !empty($row['crop_desc']) ? $row['crop_desc'] : "Freshly harvested produce available directly from local farmers.";
        ?>
        
        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="crop-card">
                <div class="card-img-wrap" data-toggle="modal" data-target="#imageModal<?php echo $tradeID; ?>">
                    <img src="<?php echo $imgSource; ?>" class="card-img-top" alt="Crop Image">
                    <div class="stock-badge">
                        <i class="fas fa-cubes mr-1"></i> <?php echo $row['total_quantity']; ?> Q
                    </div>
                </div>

                <div class="card-body">
                    <div class="crop-name"><?php echo $row['Trade_crop']; ?></div>
                    
                    <div class="crop-desc-preview">
                        <?php echo htmlspecialchars($description); ?>
                    </div>

                    <div class="small text-muted mb-3">
                        <i class="fas fa-user-friends mr-1"></i> <?php echo $row['seller_count']; ?> Farmer(s)
                    </div>

                    <div class="price-block">
                        <div>
                            <div class="small text-uppercase text-muted" style="font-size: 0.6rem;">Min Price</div>
                            <div class="price-val">₹<?php echo $row['start_price']; ?></div>
                        </div>
                        <div class="text-right small text-muted">PER QTL</div>
                    </div>

                    <a href="cbuy_crops.php?crop_search=<?php echo $row['Trade_crop']; ?>" class="btn-action">
                        <i class="fas fa-shopping-basket mr-2"></i> View Sellers
                    </a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imageModal<?php echo $tradeID; ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <img src="<?php echo $imgSource; ?>" class="w-100" style="border-radius: 15px 15px 0 0;">
                        <div class="p-4">
                            <h4 class="font-weight-bold text-dark mb-2"><?php echo $row['Trade_crop']; ?></h4>
                            <p class="text-muted" style="line-height: 1.6;">
                                <?php echo nl2br(htmlspecialchars($description)); ?>
                            </p>
                            <button type="button" class="btn btn-secondary btn-block mt-3" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            }
        } else {
            echo "<div class='col-12 text-center'><h4>No crops currently listed.</h4></div>";
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
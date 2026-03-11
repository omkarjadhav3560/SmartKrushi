<?php
session_start();
include('../sql.php'); // DB Connection

// 1. Security Check
if (!isset($_SESSION['customer_login_user'])) {
    header("location: ../index.php");
    exit();
}

// 2. Get Customer Details
$user_check = $_SESSION['customer_login_user'];
$stmt = $conn->prepare("SELECT cust_id, cust_name FROM custlogin WHERE email=? OR phone_no=?");
$stmt->bind_param("ss", $user_check, $user_check);
$stmt->execute();
$res = $stmt->get_result();
$row4 = $res->fetch_assoc();

if ($row4) {
    $cust_id = $row4['cust_id'];
    $cust_name = $row4['cust_name'];
} else {
    header("location: clogin.php"); 
    exit();
}

// 3. CART LOGIC (Add Item)
if(isset($_POST['add_to_cart'])) {
    $trade_id = $_POST['trade_id'];
    $crop_name = $_POST['crop_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price']; 
    $farmer_name = $_POST['farmer_name'];
    $available = $_POST['available_stock'];

    if($quantity > $available) {
        echo "<script>alert('Error: Not enough stock available!');</script>";
    } else {
        $item_array = array(
            'item_id'       => $trade_id,
            'item_name'     => $crop_name,
            'item_price'    => $price * $quantity, 
            'item_rate'     => $price,
            'item_quantity' => $quantity,
            'item_farmer'   => $farmer_name
        );

        if(isset($_SESSION["shopping_cart"])) {
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            if(!in_array($trade_id, $item_array_id)) {
                $count = count($_SESSION["shopping_cart"]);
                $_SESSION["shopping_cart"][$count] = $item_array;
                echo "<script>window.location.href='cbuy_crops.php?crop_search=" . urlencode($_POST['crop_search_hidden']) . "';</script>";
            } else {
                echo "<script>alert('Item already in cart!'); window.history.back();</script>";
            }
        } else {
            $_SESSION["shopping_cart"][0] = $item_array;
            echo "<script>window.location.href='cbuy_crops.php?crop_search=" . urlencode($_POST['crop_search_hidden']) . "';</script>";
        }
    }
}

// 4. CART LOGIC (Remove Item)
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    foreach ($_SESSION["shopping_cart"] as $key => $value) {
        if ($value["item_id"] == $_GET["id"]) {
            unset($_SESSION["shopping_cart"][$key]);
            echo "<script>window.history.back();</script>";
        }
    }
    $_SESSION["shopping_cart"] = array_values($_SESSION["shopping_cart"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('cheader.php'); ?>

<style>
    /* Global Styles */
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }

    /* Hero Header */
    .market-header {
        background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%) !important;
        padding-top: 5rem;
        padding-bottom: 8rem;
        color: white;
        position: relative;
        border-bottom-left-radius: 50px;
        border-bottom-right-radius: 50px;
    }

    /* Search Container */
    .search-container {
        margin-top: -4rem;
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
        z-index: 10;
    }

    /* Product Card Styling */
    .card-product {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background: #fff;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .card-product:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .crop-img-container {
        height: 200px;
        position: relative;
        overflow: hidden;
        background: #f1f3f5;
        cursor: pointer;
    }
    .crop-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .card-product:hover .crop-img {
        transform: scale(1.1);
    }
    
    .farmer-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95);
        padding: 6px 14px;
        border-radius: 25px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #333;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .price-large {
        font-size: 1.5rem;
        font-weight: 800;
        color: #28a745;
    }

    /* Info Box Styling */
    .info-box {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
    }
    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        display: block;
        margin-bottom: 2px;
        font-weight: 600;
    }
    .info-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #343a40;
    }

    /* Action Buttons */
    .btn-cart {
        background: #28a745;
        color: white;
        border: none;
        width: 100%;
        padding: 10px;
        border-radius: 0 8px 8px 0;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-cart:hover {
        background: #218838;
    }

    .qty-input {
        border-radius: 8px 0 0 8px;
        border: 1px solid #ced4da;
        text-align: center;
        font-weight: 600;
    }

    .btn-view-img {
        background: #e2e6ea;
        color: #495057;
        border: none;
        font-weight: 600;
        padding: 10px;
        border-radius: 8px;
        width: 100%;
        transition: 0.2s;
        margin-bottom: 10px;
    }
    .btn-view-img:hover {
        background: #dae0e5;
        color: #212529;
    }

    /* --- NEW CART SUMMARY DESIGN (MATCHING THE IMAGE) --- */
    .cart-summary-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-top: 50px;
        overflow: hidden;
        border: 1px solid #eef2f7;
    }

    .cart-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-title {
        color: #007bff; /* Blue color from image */
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-badge {
        background: #007bff;
        color: white;
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    .cart-table thead th {
        background: #f1f3f5;
        color: #6c757d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        border: none;
        padding: 15px 25px;
        letter-spacing: 0.5px;
    }

    .cart-table tbody td {
        vertical-align: middle;
        padding: 15px 25px;
        border-bottom: 1px solid #f8f9fa;
        color: #333;
        font-weight: 600;
    }

    .cart-footer {
        padding: 20px 25px;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 2px solid #f8f9fa;
    }

    .total-price {
        font-size: 1.6rem;
        color: #28a745;
        font-weight: 800;
    }

    .btn-checkout {
        background: #28a745;
        color: white;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 700;
        text-transform: uppercase;
        border: none;
        letter-spacing: 0.5px;
        font-size: 1rem;
        transition: 0.3s;
    }
    
    .btn-checkout:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

</style>

<body class="bg-light">
<?php include('cnav.php'); ?>

<div class="market-header text-center">
    <div class="container">
        <h1 class="display-3 font-weight-bold text-white mb-2">Fresh Market</h1>
        <p class="lead mb-0 text-white-50">Premium quality crops directly from farmers.</p>
    </div>
</div>

<div class="container pb-5">
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="search-container">
                <form method="GET" action="cbuy_crops.php">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <label class="font-weight-bold text-uppercase small text-muted">What are you looking for?</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-success"></i></span>
                                </div>
                                <select name="crop_search" class="form-control form-control-lg border-left-0" required>
                                    <option value="" disabled selected>Select a crop...</option>
                                    <option value="all" class="font-weight-bold text-primary">● All Available Crops</option>
                                    <?php
                                    $q_crops = mysqli_query($conn, "SELECT DISTINCT Trade_crop FROM farmer_crops_trade WHERE Crop_quantity > 0 ORDER BY Trade_crop ASC");
                                    while ($row_c = mysqli_fetch_assoc($q_crops)) {
                                        $selected = (isset($_GET['crop_search']) && $_GET['crop_search'] == $row_c['Trade_crop']) ? 'selected' : '';
                                        echo "<option value='{$row_c['Trade_crop']}' $selected>" . ucfirst($row_c['Trade_crop']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4 mt-md-0">
                            <button type="submit" class="btn btn-success btn-lg btn-block shadow mt-md-4">
                                Find Crops
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <?php
        if (isset($_GET['crop_search']) && !empty($_GET['crop_search'])) {
            $selected_crop = mysqli_real_escape_string($conn, $_GET['crop_search']);
            $where_clause = "";
            $display_title = "";

            if($selected_crop == "all") {
                $where_clause = "WHERE t.Crop_quantity > 0";
                $display_title = "All Available Listings";
            } else {
                $where_clause = "WHERE t.Trade_crop = '$selected_crop' AND t.Crop_quantity > 0";
                $display_title = "Listings for: <span class='text-success font-weight-bold text-uppercase'>" . $selected_crop . "</span>";
            }
            
            $sql = "SELECT 
                        t.Trade_crop,
                        SUM(t.Crop_quantity) as Crop_quantity,
                        MIN(t.costperkg) as costperkg,
                        MAX(t.msp) as msp,
                        MAX(t.crop_image) as crop_image,
                        MAX(t.Trade_id) as Trade_id,
                        f.farmer_name, 
                        f.F_District 
                    FROM farmer_crops_trade t 
                    JOIN farmerlogin f ON t.farmer_fkid = f.farmer_id 
                    $where_clause 
                    GROUP BY t.farmer_fkid, t.Trade_crop 
                    ORDER BY t.Trade_crop ASC, costperkg ASC";
            
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="col-12 mb-4"><h4 class="text-muted border-bottom pb-3">' . $display_title . '</h4></div>';
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $tradeID = $row['Trade_id'];
                    $imgName = $row['crop_image'];
                    $imgSource = "../farmer/crop_images/" . $imgName;
                    if(empty($imgName) || !file_exists($imgSource)) { $imgSource = "../assets/img/agri.png"; }
        ?>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-product">
                    <div class="crop-img-container" data-toggle="modal" data-target="#imageModal<?php echo $tradeID; ?>">
                        <img src="<?php echo $imgSource; ?>" class="crop-img" alt="Crop">
                        <div class="farmer-badge">
                            <i class="fas fa-user-circle text-success"></i> <?php echo explode(' ', $row['farmer_name'])[0]; ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h4 class="font-weight-bold text-uppercase text-dark mb-0"><?php echo $row['Trade_crop']; ?></h4>
                                <small class="text-muted"><i class="fas fa-map-marker-alt text-danger mr-1"></i> <?php echo $row['F_District']; ?></small>
                            </div>
                            <div class="text-right">
                                <div class="price-large">₹<?php echo $row['costperkg']; ?></div>
                                <small class="text-muted">/ kg</small>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-label text-success"><i class="fas fa-cubes"></i> Stock</span>
                                    <span class="info-value"><?php echo $row['Crop_quantity']; ?> Q</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-label text-warning"><i class="fas fa-tag"></i> MSP</span>
                                    <span class="info-value">₹<?php echo $row['msp']; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-view-img" data-toggle="modal" data-target="#imageModal<?php echo $tradeID; ?>">
                                    <i class="far fa-eye mr-2"></i> View Image
                                </button>
                            </div>
                            
                            <div class="col-12">
                                <form method="POST">
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control qty-input" placeholder="Qty (Q)" min="0.1" step="0.01" max="<?php echo $row['Crop_quantity']; ?>" required>
                                        <div class="input-group-append">
                                            <button type="submit" name="add_to_cart" class="btn btn-cart">
                                                <i class="fas fa-cart-plus mr-1"></i> ADD
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="trade_id" value="<?php echo $tradeID; ?>">
                                    <input type="hidden" name="crop_name" value="<?php echo $row['Trade_crop']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $row['costperkg']; ?>">
                                    <input type="hidden" name="farmer_name" value="<?php echo $row['farmer_name']; ?>">
                                    <input type="hidden" name="available_stock" value="<?php echo $row['Crop_quantity']; ?>">
                                    <input type="hidden" name="crop_search_hidden" value="<?php echo $selected_crop; ?>">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="imageModal<?php echo $tradeID; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content bg-transparent border-0">
                        <div class="modal-body text-center p-0">
                            <button type="button" class="close text-white position-absolute" style="right: -20px; top: -20px; font-size: 2rem; opacity: 1;" data-dismiss="modal">&times;</button>
                            <img src="<?php echo $imgSource; ?>" class="img-fluid rounded shadow-lg" style="max-height: 80vh;">
                        </div>
                    </div>
                </div>
            </div>

        <?php 
                } // End While
            } else {
                echo '<div class="col-12 text-center py-5"><h3 class="text-muted">No listings found.</h3></div>';
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h3 class="text-muted">Browse the market by selecting a crop above.</h3></div>';
        }
        ?>
    </div>

    <?php if(!empty($_SESSION["shopping_cart"])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="cart-summary-card">
                <div class="cart-header">
                    <h4 class="cart-title">
                        <i class="fas fa-shopping-bag"></i> Cart Summary
                    </h4>
                    <span class="cart-badge"><?php echo count($_SESSION["shopping_cart"]); ?> ITEMS</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table cart-table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Farmer</th>
                                <th>Qty (Q)</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach($_SESSION["shopping_cart"] as $keys => $values) { 
                                $total += $values["item_price"];
                            ?>
                            <tr>
                                <td class="text-uppercase font-weight-bold"><?php echo $values["item_name"]; ?></td>
                                <td class="text-muted"><?php echo $values["item_farmer"]; ?></td>
                                <td><?php echo $values["item_quantity"]; ?> Q</td>
                                <td class="font-weight-bold text-dark">₹<?php echo number_format($values["item_price"], 2); ?></td>
                                <td>
                                    <a href="cbuy_crops.php?action=delete&id=<?php echo $values["item_id"]; ?>" class="text-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-footer">
                    <div class="d-flex align-items-center">
                        <span class="h5 mb-0 text-muted mr-3">Total:</span>
                        <span class="total-price">₹<?php echo number_format($total, 2); ?></span>
                    </div>
                    <form method="POST" action="cpayment.php" class="m-0">
                        <button class="btn-checkout">
                            Checkout <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

</div>

<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
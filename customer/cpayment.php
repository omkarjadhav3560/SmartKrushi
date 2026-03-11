<?php
include ('csession.php');
include ('../sql.php');

// 1. Security: Check if cart is empty
if(empty($_SESSION["shopping_cart"])){
    echo "<script>alert('Your cart is empty!'); window.location='cbuy_crops.php';</script>";
    exit();
}

// 2. Fetch User Address for Pre-filling
$user_email = $_SESSION['customer_login_user'];
$query = "SELECT address, cust_name, phone_no FROM custlogin WHERE email='$user_email' OR phone_no='$user_email'";
$res = mysqli_query($conn, $query);
$user_row = mysqli_fetch_assoc($res);

$default_address = $user_row['address'];
$cust_name = $user_row['cust_name'];
$cust_phone = $user_row['phone_no'];

// 3. CALCULATION LOGIC (With Delivery)
$subtotal = 0;
if(!empty($_SESSION["shopping_cart"])){
    foreach($_SESSION["shopping_cart"] as $item){
        $subtotal += $item['item_price'];
    }
}

// --- DELIVERY CHARGE CONFIGURATION ---
$delivery_charge = 500; // Set your delivery fee here (e.g., ₹500 flat rate)
$grand_total = $subtotal + $delivery_charge;

// Save Grand Total to session for the database insertion page (corder_confirm.php)
$_SESSION['Total_Cart_Price'] = $grand_total;
?>

<!DOCTYPE html>
<html lang="en">
<?php include ('cheader.php'); ?>

<style>
    .checkout-header {
        background: linear-gradient(87deg, #11cdef 0, #1171ef 100%) !important;
        padding-top: 4rem;
        padding-bottom: 4rem;
    }
    .step-number {
        display: inline-block;
        width: 25px;
        height: 25px;
        background: #1171ef;
        color: #fff;
        text-align: center;
        border-radius: 50%;
        font-size: 0.9rem;
        line-height: 25px;
        margin-right: 10px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
</style>

<body class="bg-secondary">
<?php include ('cnav.php'); ?>

<div class="checkout-header">
    <div class="container text-center">
        <h1 class="display-3 text-white"><i class="fas fa-lock"></i> Secure Checkout</h1>
        <p class="text-white lead">Complete your order safely. Cash on Delivery available.</p>
    </div>
</div>

<div class="container mt--5 pb-5">
    <form action="corder_confirm.php" method="POST">
        <div class="row">
            
            <div class="col-lg-8">
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-white">
                        <h4 class="mb-0"><span class="step-number">1</span> Delivery Address</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">Confirm Shipping Address</label>
                            <textarea name="delivery_address" class="form-control" rows="3" required><?php echo $default_address; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow border-0">
                    <div class="card-header bg-white">
                        <h4 class="mb-0"><span class="step-number">2</span> Payment Method</h4>
                    </div>
                    <div class="card-body">
                        <div class="custom-control custom-radio mb-3">
                            <input name="paymentMethod" class="custom-control-input" id="cod" type="radio" value="COD" checked>
                            <label class="custom-control-label font-weight-bold" for="cod">Cash on Delivery (COD)</label>
                            <small class="d-block text-muted pl-1">Pay with cash upon receipt of your crops.</small>
                        </div>
                        
                        <hr>
                        
                        <button type="submit" name="cod_confirm" class="btn btn-success btn-lg btn-block shadow mt-4">
                            Place Order (₹<?php echo number_format($grand_total, 2); ?>)
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-white border-bottom">
                        <h4 class="mb-0 text-muted text-uppercase" style="font-size: 0.9rem;">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach ($_SESSION["shopping_cart"] as $item) { ?>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm font-weight-bold"><?php echo ucfirst($item["item_name"]); ?></h6>
                                    <small class="text-muted"><?php echo $item["item_quantity"]; ?> Q x ₹<?php echo $item["item_rate"]; ?></small>
                                </div>
                                <span class="text-dark">₹<?php echo number_format($item["item_price"]); ?></span>
                            </li>
                            <?php } ?>
                        </ul>

                        <div class="bg-light p-3 rounded">
                            <div class="summary-row text-muted">
                                <span>Subtotal</span>
                                <span>₹<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="summary-row text-muted">
                                <span>Delivery Charges</span>
                                <span class="text-danger">+ ₹<?php echo number_format($delivery_charge, 2); ?></span>
                            </div>
                            <div class="border-top my-2"></div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="h5 font-weight-bold">Total Payable</span>
                                <span class="h4 font-weight-bold text-primary">₹<?php echo number_format($grand_total, 2); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<?php include ('footer.php'); ?>
</body>
</html>
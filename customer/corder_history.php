<?php
session_start();
include('../sql.php'); 

// 1. Security & Connection Check
if (!isset($_SESSION['customer_login_user'])) {
    header("location: ../index.php");
    exit();
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Handle Actions (Confirm/Cancel)
if(isset($_POST['confirm_received'])) {
    $oid = mysqli_real_escape_string($conn, $_POST['order_id']);
    $sql = "UPDATE orders SET order_status='Completed' WHERE order_id='$oid'";
    mysqli_query($conn, $sql);
    echo "<script>alert('Order marked as Completed.'); window.location='corder_history.php';</script>";
}

if(isset($_POST['cancel_order'])) {
    $oid = mysqli_real_escape_string($conn, $_POST['order_id']);
    $items_q = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='$oid'");
    while($item = mysqli_fetch_assoc($items_q)) {
        $crop = $item['crop_name'];
        $qty = $item['quantity'];
        $fid = $item['farmer_id'];
        $restore_sql = "UPDATE farmer_crops_trade SET Crop_quantity = Crop_quantity + $qty WHERE Trade_crop='$crop' AND farmer_fkid='$fid'";
        mysqli_query($conn, $restore_sql);
    }
    mysqli_query($conn, "UPDATE orders SET order_status='Cancelled' WHERE order_id='$oid'");
    echo "<script>alert('Order #$oid Cancelled.'); window.location='corder_history.php';</script>";
}

// 3. Get Customer ID
$user_check = $_SESSION['customer_login_user'];
$query_cust = "SELECT cust_id FROM custlogin WHERE email='$user_check' OR phone_no='$user_check'";
$user_res = mysqli_query($conn, $query_cust);
$user_row = mysqli_fetch_assoc($user_res);
$cust_id = $user_row['cust_id'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include('cheader.php'); ?>
<style>
    .badge-status { padding: 8px 12px; border-radius: 30px; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; }
    .status-completed { background: #2dce89; color: white; }
    .status-pending { background: #fff3e0; color: #ef6c00; }
    .farmer-label { font-size: 0.85rem; color: #2dce89; font-weight: 500; }
</style>

<body class="bg-light">
<?php include('cnav.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4">My Order History</h2>
    
    <?php
    // Fetch Orders
    $sql_orders = "SELECT o.*, dp.partner_name 
                   FROM orders o 
                   LEFT JOIN delivery_partners dp ON o.delivery_partner_id = dp.partner_id 
                   WHERE o.cust_id = '$cust_id' ORDER BY o.date DESC";
    $res_orders = mysqli_query($conn, $sql_orders);

    if (mysqli_num_rows($res_orders) > 0) {
        while ($row = mysqli_fetch_assoc($res_orders)) {
            $current_order_id = $row['order_id']; // Define ID inside the loop
            $status = $row['order_status'];
    ?>
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white d-flex justify-content-between">
                <span><strong>Order #<?php echo $current_order_id; ?></strong></span>
                <span class="badge-status status-<?php echo strtolower($status); ?>"><?php echo $status; ?></span>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-muted small">
                            <th>Crop & Farmer</th>
                            <th>Qty</th>
                            <th class="text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // FETCH ITEMS + FARMER NAME INSIDE THE LOOP
                        $sql_items = "SELECT oi.*, f.farmer_name 
                                      FROM order_items oi 
                                      JOIN farmerlogin f ON oi.farmer_id = f.farmer_id 
                                      WHERE oi.order_id = '$current_order_id'";
                        $res_items = mysqli_query($conn, $sql_items);
                        
                        while($item = mysqli_fetch_assoc($res_items)) {
                        ?>
                        <tr>
                            <td>
                                <b><?php echo $item['crop_name']; ?></b><br>
                                <span class="farmer-label"><i class="fas fa-tractor"></i> <?php echo $item['farmer_name']; ?></span>
                            </td>
                            <td><?php echo $item['quantity']; ?> Q</td>
                            <td class="text-right">₹<?php echo number_format($item['price']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="text-right mt-3">
                    <h4>Total: ₹<?php echo number_format($row['total_amount']); ?></h4>
                    <?php if($status == 'Delivered') { ?>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $current_order_id; ?>">
                            <button name="confirm_received" class="btn btn-success btn-sm">Confirm Received</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php 
        } 
    } else {
        echo "<div class='alert alert-info'>No orders found.</div>";
    }
    ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>
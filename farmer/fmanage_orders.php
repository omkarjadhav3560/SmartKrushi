<?php
include('fsession.php');
include('../sql.php');

// 1. UPDATE LOGIC (Mark Ready)
if(isset($_POST['mark_ready'])) {
    $item_id = $_POST['item_id'];
    $update = "UPDATE order_items SET item_status='Ready for Pickup' WHERE id='$item_id'";
    if(mysqli_query($conn, $update)) {
        echo "<script>alert('Great! Admin has been notified.'); window.location='fmanage_orders.php';</script>";
    }
}

// 2. IDENTIFY FARMER (Robust Check)
$user_check = $_SESSION['farmer_login_user']; 

// Try to find the farmer ID by Email, Name, or Phone
$check_query = "SELECT farmer_id, farmer_name FROM farmerlogin 
                WHERE email='$user_check' 
                OR farmer_name='$user_check' 
                OR phone_no='$user_check'";
$check_res = mysqli_query($conn, $check_query);
$farmer_data = mysqli_fetch_array($check_res);

if($farmer_data) {
    $real_farmer_id = $farmer_data['farmer_id'];
    $real_farmer_name = $farmer_data['farmer_name'];
} else {
    $real_farmer_id = 0;
    $real_farmer_name = "Unknown";
}

// 3. FETCH ORDERS
$q = "SELECT oi.*, o.date, o.delivery_address, c.cust_name, c.phone_no
      FROM order_items oi 
      JOIN orders o ON oi.order_id = o.order_id 
      JOIN custlogin c ON o.cust_id = c.cust_id
      WHERE oi.farmer_id = '$real_farmer_id' 
      ORDER BY o.date DESC";

$res = mysqli_query($conn, $q);
$count = mysqli_num_rows($res);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('fheader.php'); ?>
<body>
<?php include('fnav.php'); ?>

<div class="container py-5">
    
    <div class="alert alert-info shadow-sm mb-4">
        <h4 class="alert-heading"><i class="fas fa-bug"></i> System Debug Report</h4>
        <hr>
        <p class="mb-0">
            <strong>Logged In User (Session):</strong> <?php echo $user_check; ?><br>
            <strong>Detected Farmer ID:</strong> <?php echo $real_farmer_id; ?> (Name: <?php echo $real_farmer_name; ?>)<br>
            <strong>Orders Found for ID <?php echo $real_farmer_id; ?>:</strong> <?php echo $count; ?>
        </p>
        <?php if($count == 0 && $real_farmer_id > 0) { ?>
            <p class="mt-2 text-danger small">
                * If you see 0 orders but you know you bought a crop, verify that the crop you bought was actually uploaded by <b>Farmer ID <?php echo $real_farmer_id; ?></b>. 
                Check the <code>order_items</code> table in your database to see which <code>farmer_id</code> is attached to that order.
            </p>
        <?php } ?>
    </div>
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h2 class="text-white font-weight-bold display-4">Incoming Orders</h2>
            <p class="text-white">Mark your crops as ready so the delivery partner can pick them up.</p>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Crop Details</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($count > 0) {
                            while($row = mysqli_fetch_assoc($res)) { 
                        ?>
                        <tr>
                            <td class="font-weight-bold">#<?php echo $row['order_id']; ?></td>
                            <td>
                                <span class="d-block font-weight-bold text-dark"><?php echo $row['cust_name']; ?></span>
                                <small class="text-muted"><i class="fas fa-phone"></i> <?php echo $row['phone_no']; ?></small>
                            </td>
                            <td class="text-success font-weight-bold text-uppercase">
                                <?php echo $row['crop_name']; ?>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-primary">
                                    <?php echo $row['quantity']; ?> Q
                                </span>
                            </td>
                            <td>
                                <?php if($row['item_status'] == 'Pending') { ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php } else { ?>
                                    <span class="badge badge-success">Ready</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($row['item_status'] == 'Pending') { ?>
                                    <form method="POST">
                                        <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="mark_ready" class="btn btn-sm btn-success shadow-sm">
                                            <i class="fas fa-check mr-1"></i> Mark Ready
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <span class="text-muted small"><i class="fas fa-check-circle text-success"></i> Notification Sent</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-5 text-muted'><h4>No new orders found for Farmer ID $real_farmer_id.</h4></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
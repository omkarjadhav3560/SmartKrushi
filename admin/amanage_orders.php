<?php
session_start();
include('../sql.php');

// 1. Assign Delivery Partner Logic
if(isset($_POST['assign_delivery'])) {
    $order_id = $_POST['order_id'];
    $partner_id = $_POST['partner_id'];
    
    $sql = "UPDATE orders SET order_status='Shipped', delivery_partner_id='$partner_id', delivery_date=NOW() WHERE order_id='$order_id'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Order #$order_id Assigned to Driver!'); window.location='amanage_orders.php';</script>";
    }
}

// 2. Mark Delivered Logic (Driver has delivered the package)
if(isset($_POST['mark_delivered'])) {
    $order_id = $_POST['order_id'];
    
    $sql = "UPDATE orders SET order_status='Delivered' WHERE order_id='$order_id'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Order #$order_id marked as Delivered!'); window.location='amanage_orders.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('aheader.php'); ?>
<body>
<?php include('anav.php'); ?>

<div class="container py-5">
    <h2 class="mb-4 text-white">Manage Orders</h2>
    <div class="card shadow">
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>Order</th>
                        <th>Customer Address</th>
                        <th>Crop Status</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_id DESC");
                    
                    // Get partners for dropdown
                    $partners = mysqli_query($conn, "SELECT * FROM delivery_partners");
                    $partner_opts = "";
                    while($p = mysqli_fetch_assoc($partners)) { 
                        $partner_opts .= "<option value='{$p['partner_id']}'>{$p['partner_name']}</option>"; 
                    }

                    while($row = mysqli_fetch_assoc($orders)) {
                        $oid = $row['order_id'];
                        // Check if farmers are ready
                        $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total, SUM(CASE WHEN item_status = 'Ready for Pickup' THEN 1 ELSE 0 END) as ready FROM order_items WHERE order_id='$oid'"));
                        $is_ready = ($check['total'] > 0 && $check['total'] == $check['ready']);
                        $crop_status = $is_ready ? "<span class='badge badge-success'>Ready for Pickup</span>" : "<span class='badge badge-warning'>Waiting for Farmers</span>";
                    ?>
                    <tr>
                        <td><b>#<?php echo $row['order_id']; ?></b><br><small><?php echo date('d M', strtotime($row['date'])); ?></small></td>
                        <td><small><?php echo substr($row['delivery_address'], 0, 30); ?>...</small></td>
                        <td><?php echo $crop_status; ?></td>
                        <td>
                            <span class="badge badge-info"><?php echo $row['order_status']; ?></span>
                        </td>
                        <td>
                            <?php if($row['order_status'] == 'Pending' || $row['order_status'] == 'Confirmed') { ?>
                                <?php if($is_ready) { ?>
                                    <form method="POST" class="d-flex">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <select name="partner_id" class="form-control form-control-sm mr-2" style="width: 120px;" required>
                                            <option value="">Select Driver</option>
                                            <?php echo $partner_opts; ?>
                                        </select>
                                        <button type="submit" name="assign_delivery" class="btn btn-sm btn-primary">Ship</button>
                                    </form>
                                <?php } else { echo "<small class='text-muted'>Wait for crops</small>"; } ?>

                            <?php } elseif ($row['order_status'] == 'Shipped') { ?>
                                <form method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <button type="submit" name="mark_delivered" class="btn btn-sm btn-warning text-white shadow">
                                        <i class="fas fa-truck-loading"></i> Mark Delivered
                                    </button>
                                </form>

                            <?php } else { ?>
                                <span class="text-success"><i class="fas fa-check-circle"></i> Completed</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
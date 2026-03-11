<?php
include ('../sql.php'); 
// Suggestion: Add admin session check here if not already in sql.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table td { vertical-align: middle; }
        .badge-pill { padding: 0.5em 1em; }
    </style>
</head>
<body class="bg-light p-4">
    <div class="container-fluid shadow p-4 bg-white rounded">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h2 class="text-primary mb-0"><i class="fas fa-tasks"></i> Customer Order Management</h2>
            <span class="badge badge-info p-2">Total Orders: 
                <?php 
                    $count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
                    echo mysqli_fetch_assoc($count_res)['total'];
                ?>
            </span>
        </div>

        <table class="table table-hover table-striped border">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Order ID</th>
                    <th>Date & Time</th>
                    <th>Buyer Information</th>
                    <th>Delivery Address</th>
                    <th>Items (Qty)</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // JOIN orders with custlogin to get buyer info
                $sql = "SELECT o.*, c.cust_name, c.phone_no, c.email 
                        FROM orders o 
                        JOIN custlogin c ON o.cust_id = c.cust_id 
                        ORDER BY o.date DESC";
                $res = mysqli_query($conn, $sql);

                if(mysqli_num_rows($res) > 0) {
                    while($order = mysqli_fetch_assoc($res)) {
                        $oid = $order['order_id'];
                        
                        // Get items for this specific order
                        $item_sql = "SELECT GROUP_CONCAT(CONCAT(crop_name, ' (', quantity, 'kg)') SEPARATOR '<br>') as items 
                                     FROM order_items WHERE order_id = $oid";
                        $item_res = mysqli_query($conn, $item_sql);
                        $item_data = mysqli_fetch_assoc($item_res);
                        $items = $item_data['items'];
                        ?>
                        <tr>
                            <td class="text-center font-weight-bold">#ORD-<?php echo $oid; ?></td>
                            <td class="text-center small"><?php echo date('d M Y', strtotime($order['date'])); ?><br><?php echo date('h:i A', strtotime($order['date'])); ?></td>
                            <td>
                                <strong><?php echo $order['cust_name']; ?></strong><br>
                                <small class="text-muted"><i class="fas fa-phone-alt"></i> <?php echo $order['phone_no']; ?></small>
                            </td>
                            <td>
                                <small><i class="fas fa-map-marker-alt text-danger"></i> <?php echo $order['delivery_address']; ?></small>
                            </td>
                            <td class="small"><?php echo $items; ?></td>
                            <td class="text-center font-weight-bold">Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                            <td class="text-center">
                                <?php 
                                    $status = $order['order_status'];
                                    $badge = "badge-warning"; // Pending
                                    if($status == 'Confirmed') $badge = "badge-success";
                                    if($status == 'Cancelled') $badge = "badge-danger";
                                ?>
                                <span class="badge badge-pill <?php echo $badge; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <?php if($order['order_status'] == 'Pending') { ?>
                                        <a href="update_order.php?id=<?php echo $oid; ?>&status=Confirmed" class="btn btn-sm btn-success" title="Confirm Order">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php } ?>
                                    <a href="update_order.php?id=<?php echo $oid; ?>&status=Cancelled" class="btn btn-sm btn-danger" title="Cancel Order" onclick="return confirm('Are you sure you want to cancel this order?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php 
                    } 
                } else {
                    echo "<tr><td colspan='8' class='text-center p-5'><h4>No orders found.</h4></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
session_start();
include('../sql.php'); 

// 1. Security Check (Farmer side)
if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// 2. Identify Farmer
$user_check = $_SESSION['farmer_login_user'];
$query_user = "SELECT farmer_id FROM farmerlogin WHERE email='$user_check' OR phone_no='$user_check'";
$res_user = mysqli_query($conn, $query_user);
$row_user = mysqli_fetch_assoc($res_user);
$farmer_id = $row_user['farmer_id'];

?>

<!DOCTYPE html>
<html lang="en">
<?php include('fheader.php'); ?>
<style>
    .price-text { color: #2dce89; font-weight: 700; font-size: 1.1rem; }
    .badge-sold { background: #e8f5e9; color: #2e7d32; padding: 5px 15px; border-radius: 20px; font-weight: 600; }
</style>

<body class="bg-light">
<?php include('fnav.php'); ?>

<div class="container py-5">
    <div class="card shadow border-0">
        <div class="card-header bg-white"><h3 class="mb-0">Sales History (Earnings)</h3></div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Crop Name</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // This query matches your Customer History logic
                    // We fetch from order_items and join orders + custlogin
                    $sql = "SELECT oi.*, o.date, o.order_status, c.cust_name 
                            FROM order_items oi
                            JOIN orders o ON oi.order_id = o.order_id
                            JOIN custlogin c ON o.cust_id = c.cust_id
                            WHERE oi.farmer_id = '$farmer_id' 
                            AND (o.order_status = 'Completed' OR o.order_status = 'Delivered')
                            ORDER BY o.date DESC";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Calculate total using the 'price' column from order_items
                            // Multiply by quantity if 'price' is a unit price
                            $total_earning = $row['price'] * $row['quantity'];
                    ?>
                    <tr>
                        <td><?php echo date("d M Y", strtotime($row['date'])); ?></td>
                        <td><b><?php echo strtoupper($row['crop_name']); ?></b></td>
                        <td><?php echo $row['cust_name']; ?></td>
                        <td><?php echo $row['quantity']; ?> Q</td>
                        <td><span class="price-text">₹<?php echo number_format($total_earning); ?></span></td>
                        <td><span class="badge-sold">COMPLETED</span></td>
                    </tr>
                    <?php 
                        } 
                    } else { 
                        echo "<tr><td colspan='6' class='text-center py-4'>No sales records found.</td></tr>"; 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
<?php
include ('csession.php');
include ('../sql.php');

if(!isset($_GET['id'])){
    header("location: cbuy_crops.php");
    exit();
}
$order_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<?php include ('cheader.php'); ?>
<body class="bg-light">
<?php include ('cnav.php'); ?>

<div class="container mt-5 text-center">
    <div class="card shadow border-0 py-5">
        <div class="card-body">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success fa-5x"></i>
            </div>
            <h1 class="display-4 text-success font-weight-bold">Order Placed!</h1>
            <p class="lead">Thank you for shopping with SmartKrushi.</p>
            <p class="mb-4">Your Order ID is <strong>#<?php echo $order_id; ?></strong></p>
            
            <a href="cbuy_crops.php" class="btn btn-primary">Continue Shopping</a>
            <a href="../index.php" class="btn btn-outline-primary">Go Home</a>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>
</body>
</html>
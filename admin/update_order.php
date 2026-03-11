<?php
include ('../sql.php');

if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    $query = "UPDATE orders SET order_status = '$status' WHERE order_id = $id";
    if(mysqli_query($conn, $query)) {
        header("Location: manage_orders.php?msg=Status Updated");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
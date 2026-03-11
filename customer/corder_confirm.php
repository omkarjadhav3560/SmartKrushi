<?php
session_start();
include ('../sql.php'); // DB Connection

// Security Check
if (!isset($_SESSION['customer_login_user'])) {
    header("location: ../index.php");
    exit();
}

if (isset($_POST['cod_confirm'])) {
    
    // 1. Get Customer ID from Database (Fixes Undefined Index error)
    $user_check = $_SESSION['customer_login_user'];
    $sql_user = "SELECT cust_id FROM custlogin WHERE email='$user_check' OR phone_no='$user_check'";
    $result_user = mysqli_query($conn, $sql_user);
    $row_user = mysqli_fetch_assoc($result_user);
    
    if($row_user) {
        $cust_id = $row_user['cust_id'];
    } else {
        echo "<script>alert('Error: Customer not found.'); window.location='cbuy_crops.php';</script>";
        exit();
    }

    $total_price = $_SESSION['Total_Cart_Price'];
    $order_date = date("Y-m-d H:i:s");
    $delivery_address = mysqli_real_escape_string($conn, $_POST['delivery_address']);

    // 2. Create the Main Order
    $query_order = "INSERT INTO `orders` (cust_id, delivery_address, total_amount, payment_type, order_status, date) 
                    VALUES ('$cust_id', '$delivery_address', '$total_price', 'COD', 'Pending', '$order_date')";
    
    if (mysqli_query($conn, $query_order)) {
        $order_id = mysqli_insert_id($conn); // Get the new Order ID

        // 3. Process Each Item in Cart
        if(isset($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                
                $trade_id = $values["item_id"]; // This is the Trade ID from farmer_crops_trade
                $item_name = mysqli_real_escape_string($conn, $values["item_name"]);
                $item_quantity = $values["item_quantity"];
                $item_price = $values["item_price"];
                
                // A. FIND THE FARMER ID (Crucial for Selling History)
                $farmer_query = "SELECT farmer_fkid FROM farmer_crops_trade WHERE Trade_id='$trade_id'";
                $farmer_res = mysqli_query($conn, $farmer_query);
                $farmer_row = mysqli_fetch_assoc($farmer_res);
                $farmer_id = $farmer_row['farmer_fkid'];

                // B. Insert Item with Farmer ID
                $query_items = "INSERT INTO `order_items` (order_id, farmer_id, crop_name, quantity, price) 
                                VALUES ('$order_id', '$farmer_id', '$item_name', '$item_quantity', '$item_price')";
                mysqli_query($conn, $query_items);

                // C. REDUCE STOCK (Real-time Inventory Update)
                $update_stock = "UPDATE farmer_crops_trade SET Crop_quantity = Crop_quantity - $item_quantity WHERE Trade_id='$trade_id'";
                mysqli_query($conn, $update_stock);
            }
        }

        // 4. Cleanup Cart
        unset($_SESSION["shopping_cart"]);
        unset($_SESSION["Total_Cart_Price"]);
        
        // Redirect to Success Page
        echo "<script>alert('Order Placed Successfully!'); window.location='corder_success.php?id=" . $order_id . "';</script>";
        exit();
        
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("location: cbuy_crops.php");
}
?>
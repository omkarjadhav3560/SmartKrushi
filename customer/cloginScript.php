<?php
session_start();
$error = ''; 
require('../sql.php'); 

if(isset($_POST ['customerlogin'])) {
    $customer_email = mysqli_real_escape_string($conn, $_POST['cust_email']);
    $customer_password = mysqli_real_escape_string($conn, $_POST['cust_password']);

    // Check if input is email or phone number
    if (filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $checkquery = "SELECT * from `custlogin` where email='$customer_email' and password='$customer_password'";
    } else {
        $checkquery = "SELECT * from `custlogin` where phone_no='$customer_email' and password='$customer_password'";
    }
    
    $result = mysqli_query($conn, $checkquery);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['customer_login_user'] = $customer_email; 
        $_SESSION['cust_id'] = $row['cust_id']; 

        // Clear cart on new login
        $deletequery="DELETE FROM cart";
        mysqli_query($conn,$deletequery);

        header("location: cbuy_crops.php"); 
    } else {
       echo "<script>alert('Invalid Email/Phone or Password'); window.location='clogin.php';</script>";
    }
    mysqli_close($conn);
}
?>
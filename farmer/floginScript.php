<?php
session_start();
$error = ''; 
require('../sql.php'); 

if(isset($_POST['farmerlogin'])) {
    $farmer_email = mysqli_real_escape_string($conn, $_POST['farmer_email']);
    $farmer_password = mysqli_real_escape_string($conn, $_POST['farmer_password']);

    // Check if input is email or phone number
    if (filter_var($farmer_email, FILTER_VALIDATE_EMAIL)) {
        $farmerquery = "SELECT * from `farmerlogin` where email='$farmer_email' AND password='$farmer_password'";
    } else {
        $farmerquery = "SELECT * from `farmerlogin` where phone_no='$farmer_email' AND password='$farmer_password'";
    }
    
    $result = mysqli_query($conn, $farmerquery);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // If you switch to password_hash, use: if(password_verify($farmer_password, $row['password'])) { ... }
        
        $_SESSION['farmer_login_user'] = $row['email']; // Better to store ID usually, but sticking to your logic
        $_SESSION['farmer_id'] = $row['farmer_id']; 
        
        header("location: ftradecrops.php"); 
    } else {
       echo "<script>alert('Invalid Username or Password'); window.location='flogin.php';</script>";
    }
    mysqli_close($conn);
}
?>
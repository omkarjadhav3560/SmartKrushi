<?php
session_start();
require('../sql.php'); 
global $error;
$error = "";

// 1. Check if Email Exists
function check_email_exists($email) {
    global $conn;
    $query = "SELECT cust_id FROM custlogin WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        return true; 
    }
    return false;
}

// 2. Create User Function (Updated with Profile Pic)
function create_user($name, $password, $email, $mobile, $statename, $city, $address, $pincode, $profile_pic) {
    global $conn;
    
    // Note: Assuming you added a 'profile_pic' column to 'custlogin' table.
    // SQL Query
    $query = "INSERT INTO `custlogin` (cust_name, password, email, phone_no, state, city, address, pincode, profile_pic) 
              VALUES ('$name', '$password', '$email', '$mobile', '$statename', '$city', '$address', '$pincode', '$profile_pic')";
    
    return mysqli_query($conn, $query);
}

// 3. Execution
if (isset($_POST['customerregister'])){
    // Sanitize Inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $state = $_POST['state'];
    $city = mysqli_real_escape_string($conn, $_POST['city']); // City ID or Name depending on your cget_district logic
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

    // Get State Name
    $query5 = "SELECT StateName from state where StCode ='$state'";
    $ses_sq5 = mysqli_query($conn, $query5);
    $row5 = mysqli_fetch_assoc($ses_sq5);
    $statename = $row5['StateName'];

    // Handle Image Upload
    $profile_pic = "default_cust.png"; // Default
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){
        $target_dir = "../assets/img/";
        // Create folder if not exists
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        
        $extension = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
        $new_filename = "cust_" . time() . "." . $extension;
        
        if(move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_dir . $new_filename)){
            $profile_pic = $new_filename;
        }
    }

    if ($password == $cpassword) {
        if (!check_email_exists($email)) {
            if (create_user($name, $password, $email, $mobile, $statename, $city, $address, $pincode, $profile_pic)) {
                $_SESSION['customer_login_user'] = $email;
                header("location: cbuy_crops.php");
            } else {
                 $error = '<div class="alert alert-danger">Registration Failed. Database Error: '.mysqli_error($conn).'</div>';
            }
        } else {
            $error = '<div class="alert alert-warning">Email already registered!</div>';
        }
    } else {
        $error = '<div class="alert alert-danger">Passwords do not match!</div>';
    }
}
?>
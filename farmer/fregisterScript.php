<?php
session_start();
require('../sql.php'); 
global $error;
$error = "";

// 1. Check if Email or Phone Exists
function check_existence($email, $phone) {
    global $conn;
    $query = "SELECT farmer_id FROM farmerlogin WHERE email = '$email' OR phone_no = '$phone'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        return true; 
    }
    return false;
}

// 2. Create User Function
function create_user($name, $password, $email, $mobile, $gender, $dob, $statename, $district, $city, $profile_pic) {
    global $conn;
    
    // SECURE: Hash the password
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
    // For now, using your original logic as requested, but HIGHLY recommend hashing.
    // Assuming simple storage for now based on your login script:
    $stored_pass = $password; 

    $query = "INSERT INTO `farmerlogin` (farmer_name, password, email, phone_no, F_gender, F_birthday, F_State, F_District, F_Location, F_profile_pic) 
              VALUES ('$name', '$stored_pass', '$email', '$mobile', '$gender', '$dob', '$statename', '$district', '$city', '$profile_pic')";
    
    return mysqli_query($conn, $query);
}

// 3. Execution
if (isset($_POST['farmerregister'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    
    // Get State Name
    $query5 = "SELECT StateName from state where StCode ='$state'";
    $ses_sq5 = mysqli_query($conn, $query5);
    $row5 = mysqli_fetch_assoc($ses_sq5);
    $statename = $row5['StateName'];

    // Handle Image Upload
    $profile_pic = "default_user.png"; // Default
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){
        $target_dir = "../assets/img/";
        // Create folder if not exists
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        
        $extension = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
        $new_filename = "farmer_" . time() . "." . $extension;
        
        if(move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_dir . $new_filename)){
            $profile_pic = $new_filename;
        }
    }

    if ($password == $cpassword) {
        if (!check_existence($email, $mobile)) {
            if (create_user($name, $password, $email, $mobile, $gender, $dob, $statename, $district, $city, $profile_pic)) {
                $_SESSION['farmer_login_user'] = $email;
                header("location: fstock_crop.php");
            } else {
                 $error = '<div class="alert alert-danger">Registration Failed. Database Error.</div>';
            }
        } else {
            $error = '<div class="alert alert-warning">Email or Mobile already registered!</div>';
        }
    } else {
        $error = '<div class="alert alert-danger">Passwords do not match!</div>';
    }
}
?>
<?php
// mysqli_connect() function opens a new connection to the MySQL server.
$conn = mysqli_connect("localhost:3306", "root", "", "agriculture_portal");
session_start();// Starting Session

// Check if session exists
if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// Storing Session
$user_check = $_SESSION['farmer_login_user'];

// SQL Query To Fetch Complete Information Of User
// Check if user_check is email or phone number
if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query = "SELECT farmer_name from farmerlogin where email = '$user_check'";
} else {
    $query = "SELECT farmer_name from farmerlogin where phone_no = '$user_check'";
}

$ses_sql = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($ses_sql);

// Check if row exists before accessing array
if($row && isset($row['farmer_name'])) {
    $login_session = $row['farmer_name'];
} else {
    $login_session = '';
    // Redirect to login if user not found
    header("location: flogin.php");
    exit();
}

$CustID=$user_check;
?>


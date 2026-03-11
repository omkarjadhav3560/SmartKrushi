<?php
require_once("../sql.php");
session_start();

// Check if session exists
if (!isset($_SESSION['customer_login_user'])) {
    header("location: ../index.php");
    exit();
}

$user_check = $_SESSION['customer_login_user'];

// Check if email or phone
if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query = "SELECT cust_name FROM custlogin WHERE email='$user_check'";
} else {
    $query = "SELECT cust_name FROM custlogin WHERE phone_no='$user_check'";
}

$ses_sql = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($ses_sql);

if ($row && isset($row['cust_name'])) {
    $login_session = $row['cust_name'];
} else {
    header("location: clogin.php");
    exit();
}

$CustID = $user_check;
?>

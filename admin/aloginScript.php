<?php
session_start();
require('../sql.php'); // Database connection

$error = ''; // Initialize error variable

if (isset($_POST['adminlogin'])) {
    
    // 1. Get the input
    $aname = $_POST['admin_id'];       // Form field name is 'admin_id'
    $apassword = $_POST['admin_password'];

    // 2. Security: Prevent SQL Injection (Important!)
    $aname = mysqli_real_escape_string($conn, $aname);
    $apassword = mysqli_real_escape_string($conn, $apassword);

    // 3. The Query
    // We search the 'admin_name' column because your database screenshot shows 
    // the email is stored inside 'admin_name', not 'admin_email'.
    $adminquery = "SELECT * FROM `admin` 
                   WHERE `admin_name` = '$aname' 
                   AND `admin_password` = '$apassword'";

    // 4. Run Query
    $result = mysqli_query($conn, $adminquery);

    if ($result) {
        $rowcount = mysqli_num_rows($result);

        if ($rowcount == 1) {
            // Success!
            $_SESSION['admin_login_user'] = $aname;
            header("location: aprofile.php"); 
            exit(); // Stop script here
        } else {
            // Failed
            $error = "Invalid Username or Password";
        }
    } else {
        // Database Error
        die("Query Failed: " . mysqli_error($conn));
    }
}
?>
<?php
session_start();
// Include your database connection file
// If your file is in a different folder, use: include('../includes/db_config.php');
include('db_config.php'); 

if(isset($_POST['mobile'])) {
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    
    // Check if the farmer exists in the database
    $check_user = mysqli_query($conn, "SELECT * FROM farmer WHERE f_mobile = '$mobile'");
    
    if(mysqli_num_rows($check_user) > 0) {
        // User exists, generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['session_otp'] = $otp;
        $_SESSION['session_mobile'] = $mobile;

        // --- SMS API START (Fast2SMS) ---
        $fields = array(
            "variables_values" => "$otp",
            "route" => "otp",
            "numbers" => "$mobile",
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: YOUR_ACTUAL_API_KEY_HERE",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // --- SMS API END ---

        echo "success"; 
    } else {
        // User does not exist
        echo "This mobile number is not registered.";
    }
}
?>
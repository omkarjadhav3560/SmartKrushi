<?php 
session_start();
ini_set('memory_limit', '-1');
$userlogin = $_SESSION['farmer_login_user'];

require('../sql.php'); // DB Connection

if(isset($_POST['Crop_submit'])){
    
    // 1. Sanitize Inputs
    $trade_crop = mysqli_real_escape_string($conn, $_POST['crops']);
    $quantity   = mysqli_real_escape_string($conn, $_POST['trade_farmer_cropquantity']); 
    $cost       = mysqli_real_escape_string($conn, $_POST['trade_farmer_cost']); 
    
    // NEW FEATURE: Sanitize the Crop Description/Info
    $crop_info  = mysqli_real_escape_string($conn, $_POST['trade_farmer_cropinfo']);
    
    // 2. Get Farmer ID
    if (filter_var($userlogin, FILTER_VALIDATE_EMAIL)) {
        $query1 = "SELECT farmer_id from farmerlogin where email='$userlogin'";
    } else {
        $query1 = "SELECT farmer_id from farmerlogin where phone_no='$userlogin'";
    }
    
    $run = mysqli_query($conn, $query1);
    $row = mysqli_fetch_array($run);
    
    if($row && isset($row[0])) {
        $farmer_pid = $row[0];
    } else {
        echo "<script>alert('Session Expired. Please Login.'); window.location='flogin.php';</script>";
        exit();
    }

    // 3. Image Upload Handling
    $image_path = "default.png"; 
    
    if(isset($_FILES['crop_image']) && $_FILES['crop_image']['error'] == 0){
        $target_dir = "crop_images/"; 
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $fileType = strtolower(pathinfo($_FILES["crop_image"]["name"], PATHINFO_EXTENSION));
        $allowed = array("jpg", "jpeg", "png", "gif");
        
        if(in_array($fileType, $allowed)){
            $new_filename = $trade_crop . "_" . $farmer_pid . "_" . time() . "." . $fileType;
            $target_file = $target_dir . $new_filename;
            
            if(move_uploaded_file($_FILES["crop_image"]["tmp_name"], $target_file)){
                $image_path = $new_filename;
            } else {
                echo "<script>alert('Error uploading image.'); window.location='ftradecrops.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid Image Type. Only JPG, PNG, GIF allowed.'); window.location='ftradecrops.php';</script>";
            exit();
        }
    }

    // 4. Insert Data into Database (Added 'crop_description' column)
    $query2 = "INSERT INTO `farmer_crops_trade` 
               (`farmer_fkid`, `Trade_crop`, `Crop_quantity`, `costperkg`, `crop_image`, `crop_description`) 
               VALUES ('$farmer_pid', '$trade_crop', '$quantity', '$cost', '$image_path', '$crop_info')";
    
    $result = mysqli_query($conn, $query2);

    if($result) {
        // 5. Update MSP Logic
        $x = 0; 
        $y = 0;
        $query_msp = "SELECT costperkg from farmer_crops_trade where Trade_crop='$trade_crop'";
        $result_msp = mysqli_query($conn, $query_msp);
        
        while($row_msp = $result_msp->fetch_assoc()) {
            $x = $x + $row_msp["costperkg"];
            $y++;
        }

        if($y > 0){
            $x = CEIL($x/$y); 
            $x = $x + CEIL($x*0.5); 
        }

        $query3 = "UPDATE farmer_crops_trade SET msp='$x' where Trade_crop='$trade_crop'";
        mysqli_query($conn, $query3);

        // 6. Update Total Production Stats
        $query4 = "UPDATE production_approx SET quantity=quantity+'$quantity' where crop='$trade_crop'";
        mysqli_query($conn, $query4);

        echo "<script>alert('Success! Stock updated with description.'); window.location='ftradecrops.php';</script>";
    } else {
        echo "<script>alert('Database Error: " . mysqli_error($conn) . "'); window.location='ftradecrops.php';</script>";
    }
}
?>
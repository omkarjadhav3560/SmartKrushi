<?php
session_start();
require('../sql.php'); 
require('get_price_breakdown.php'); 

if(isset($_POST['add_to_cart'])){
    $crop = mysqli_real_escape_string($conn, $_POST['crops']);
    $quantity = (int)$_POST['quantity'];
    $tradeID = mysqli_real_escape_string($conn, $_POST['tradeid']);
    $price = (float)$_POST['price'];

    // DATABASE: Check if crop already exists in cart table to prevent Duplicate Entry Error
    $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `cropname` = '$crop'");
    
    if(mysqli_num_rows($check_cart) > 0) {
        $query4 = "UPDATE `cart` SET `quantity` = `quantity` + $quantity, `price` = `price` + $price WHERE `cropname` = '$crop'";
    } else {
        $query4 = "INSERT INTO `cart` (`cropname`, `quantity`, `price`) VALUES ('$crop', '$quantity', '$price')";
    }
    mysqli_query($conn, $query4);

    // SESSION: Update or Create shopping cart array
    $priceBreakdown = getPriceBreakdown($conn, $crop, $quantity);
    
    if(isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($tradeID, $item_array_id)) {
            $item_array = array(
                'item_id' => $tradeID,
                'item_name' => $crop,
                'item_price' => $price,
                'item_quantity' => $quantity,
                'price_breakdown' => $priceBreakdown['breakdown']
            );
            array_push($_SESSION['shopping_cart'], $item_array);
        } else {
            // Update quantity in session if already exists
            foreach($_SESSION["shopping_cart"] as $keys => $values) {
                if($values["item_id"] == $tradeID) {
                    $_SESSION["shopping_cart"][$keys]['item_quantity'] += $quantity;
                    $_SESSION["shopping_cart"][$keys]['item_price'] += $price;
                }
            }
        }
    } else {
        $_SESSION["shopping_cart"][0] = array(
            'item_id' => $tradeID,
            'item_name' => $crop,
            'item_price' => $price,
            'item_quantity' => $quantity,
            'price_breakdown' => $priceBreakdown['breakdown']
        );
    }
    header("Location: cbuy_crops.php?action=add&id=$tradeID");
    exit();
}
?>
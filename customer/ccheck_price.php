<?php
session_start();
require('../sql.php'); // Includes SQL connection script

if (isset($_POST['crops']) && isset($_POST['quantity'])) {

  $crop=$_POST['crops'];
  $quantity=$_POST['quantity'];
  
  // Get both MSP and average cost per kg
  $query="SELECT msp, AVG(costperkg) as avg_cost from farmer_crops_trade where Trade_crop='$crop'";
  $result = mysqli_query($conn, $query);
  $row = $result->fetch_assoc();
  
  // Check if row exists before accessing array
  if($row && isset($row["msp"]) && isset($row["avg_cost"])) {
      $msp_per_kg = $row["msp"];
      $base_cost_per_kg = CEIL($row["avg_cost"]);
      
      $base_price = $base_cost_per_kg * $quantity;
      $delivery_charge = CEIL($base_cost_per_kg * 0.3) * $quantity; // 30% as delivery
      $service_charge = CEIL($base_cost_per_kg * 0.2) * $quantity;  // 20% as service
      $total_price = $msp_per_kg * $quantity;
      
      // Return JSON with breakdown
      echo json_encode([
          'total' => $total_price,
          'base_price' => $base_price,
          'delivery_charge' => $delivery_charge,
          'service_charge' => $service_charge,
          'breakdown' => "Base Price: ₹{$base_price} + Delivery: ₹{$delivery_charge} + Service: ₹{$service_charge} = Total: ₹{$total_price}"
      ]);
  } else {
      echo json_encode(['total' => 0, 'breakdown' => 'Price not available']);
  }
}
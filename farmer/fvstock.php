<?php
session_start();
include('db_config.php'); 

// Check if Farmer is logged in
if (!isset($_SESSION['farmer_id'])) {
    header("location: flogin.php");
    exit();
}

$farmer_id = $_SESSION['farmer_id'];
$message = "";

// --- ADD VEGETABLE LOGIC ---
if (isset($_POST['add_veg'])) {
    $name = mysqli_real_escape_string($conn, $_POST['veg_name']);
    $qty = mysqli_real_escape_string($conn, $_POST['quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $type = mysqli_real_escape_string($conn, $_POST['veg_type']);

    $query = "INSERT INTO veg_stock (farmer_id, veg_name, quantity, price_per_kg, veg_type) 
              VALUES ('$farmer_id', '$name', '$qty', '$price', '$type')";
    
    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success shadow'>Vegetable stock updated!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// --- DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM veg_stock WHERE id=$id AND farmer_id=$farmer_id");
    header("location: vstock.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Vegetable Stock | Agriculture Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <style>
        .bg-gradient-success { background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important; }
        .card { border-radius: 15px; }
    </style>
</head>
<body class="bg-white">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-gradient-success shadow border-0">
                <div class="card-body">
                    <h4 class="text-white mb-4"><i class="fas fa-leaf"></i> Add Vegetable</h4>
                    <?php echo $message; ?>
                    <form method="POST">
                        <div class="form-group">
                            <label class="text-white">Vegetable Name</label>
                            <input type="text" name="veg_name" class="form-control" placeholder="Tomato, Potato, etc." required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-white">Quantity (Kg)</label>
                                    <input type="number" name="quantity" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-white">Price/Kg (₹)</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-white">Cultivation Type</label>
                            <select name="veg_type" class="form-control">
                                <option value="Standard">Standard</option>
                                <option value="Organic">Organic</option>
                            </select>
                        </div>
                        <button type="submit" name="add_veg" class="btn btn-white btn-block text-success font-weight-bold">
                            Post Vegetable
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header border-0">
                    <h3 class="mb-0">My Vegetable Inventory</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Available Qty</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM veg_stock WHERE farmer_id = '$farmer_id' ORDER BY id DESC");
                            while ($row = mysqli_fetch_assoc($result)) {
                                $badge = ($row['veg_type'] == 'Organic') ? 'badge-success' : 'badge-info';
                                echo "<tr>
                                        <td><b>{$row['veg_name']}</b></td>
                                        <td><span class='badge badge-pill $badge'>{$row['veg_type']}</span></td>
                                        <td>{$row['quantity']} Kg</td>
                                        <td>₹{$row['price_per_kg']}</td>
                                        <td>
                                            <a href='vstock.php?delete={$row['id']}' class='text-danger' onclick='return confirm(\"Are you sure?\")'>
                                                <i class='fas fa-trash-alt'></i> Delete
                                            </a>
                                        </td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
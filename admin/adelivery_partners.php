<?php
session_start();
include('../sql.php');

// --- 1. HANDLE ADDING PARTNER (SECURE) ---
if(isset($_POST['add_partner'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $vehicle = $_POST['vehicle'];

    $stmt = $conn->prepare("INSERT INTO delivery_partners (partner_name, phone_no, vehicle_no) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $phone, $vehicle);
    
    if($stmt->execute()) {
        echo "<script>alert('Partner Added Successfully'); window.location.href=window.location.pathname;</script>";
    }
    $stmt->close();
}

// --- 2. HANDLE DELETING PARTNER (SECURE) ---
if(isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];

    $stmt = $conn->prepare("DELETE FROM delivery_partners WHERE partner_id = ?");
    $stmt->bind_param("i", $del_id);
    
    if($stmt->execute()) {
        echo "<script>alert('Partner Deleted Successfully'); window.location.href=window.location.pathname;</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('aheader.php'); ?>
<body>
<?php include('anav.php'); ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Add Delivery Partner</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>Driver Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="10-digit number" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Vehicle Number</label>
                                <input type="text" name="vehicle" class="form-control" placeholder="e.g. ABC-1234" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>&nbsp;</label>
                                <button type="submit" name="add_partner" class="btn btn-dark btn-block mt-auto">Add Partner</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-0 text-dark">Delivery Partners List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Partner Name</th>
                                <th>Phone</th>
                                <th>Vehicle No</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q = mysqli_query($conn, "SELECT * FROM delivery_partners ORDER BY partner_id DESC");
                            if(mysqli_num_rows($q) > 0) {
                                while($row = mysqli_fetch_assoc($q)) {
                                    echo "<tr>
                                            <td>#{$row['partner_id']}</td>
                                            <td><span class='badge badge-dot mr-4'><i class='bg-info'></i></span> <b>{$row['partner_name']}</b></td>
                                            <td>{$row['phone_no']}</td>
                                            <td><span class='badge badge-secondary'>{$row['vehicle_no']}</span></td>
                                            <td class='text-center'>
                                                <a href='?del_id={$row['partner_id']}' 
                                                   class='btn btn-outline-danger btn-sm' 
                                                   onclick='return confirm(\"Are you sure you want to remove this partner?\")'>
                                                   <i class='fas fa-trash-alt'></i> Delete
                                                </a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4'>No partners found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
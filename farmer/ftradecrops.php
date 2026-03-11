<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

// 1. Security Check
if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// 2. Get User Info
if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query4 = "SELECT * from farmerlogin where email='$user_check'";
} else {
    $query4 = "SELECT * from farmerlogin where phone_no='$user_check'";
}

$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);

if($row4 && isset($row4['farmer_id'])) {
    $para1 = $row4['farmer_id'];
    $para2 = $row4['farmer_name'];
} else {
    header("location: flogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include ('fheader.php'); ?>

<style>
    /* Hero Header Styling */
    .trade-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../assets/img/harvest.jpg');
        background-size: cover;
        background-position: center;
        padding-top: 80px;
        padding-bottom: 150px;
    }

    .form-control-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #32325d;
    }

    .custom-file-label::after {
        content: "Browse";
    }
    
    .input-group-text {
        background-color: #fff;
    }
</style>

<body class="bg-light">
<?php include ('fnav.php'); ?>

<div class="trade-header">
    <div class="container">
        <div class="text-center">
            <h1 class="display-3 text-white font-weight-bold"><i class="fas fa-balance-scale"></i> Trade Market</h1>
            <p class="lead text-white-50">Bulk trading made easy. List your Quintals and get the best market rates.</p>
        </div>
    </div>
</div>

<div class="container mt--8 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-white pb-3">
                    <div class="text-center mb-1">
                        <h3 class="text-success font-weight-bold">Update Crop Stock</h3>
                        <p class="small text-muted mb-0">Fill in the details below to publish your listing (In Quintals).</p>
                    </div>
                </div>
                
                <div class="card-body px-lg-5 py-lg-5">
                    
                    <form role="form" onsubmit="return tradecrops()" id="sellcrops" action="ftradecropsScript.php" method="POST" enctype="multipart/form-data">

                        <div class="alert alert-primary alert-dismissible fade show" role="alert" id="popup" style="display: none;">
                            <span class="alert-inner--icon"><i class="fas fa-info-circle"></i></span>
                            <span class="alert-inner--text"><strong>Market Insight:</strong> Avg Price for <span id="crop_name_display" class="font-weight-bold text-uppercase"></span> is <strong>₹<span id="price"></span>/Quintal</strong></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-control-label">Select Crop</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-seedling text-success"></i></span>
                                        </div>
                                        <select id="crops" name="crops" class="form-control" required>
                                            <option value="">Choose Crop...</option>
                                            <option value="arhar">Arhar</option>
                                            <option value="bajra">Bajra</option>
                                            <option value="barley">Barley</option>
                                            <option value="cotton">Cotton</option>
                                            <option value="gram">Gram</option>
                                            <option value="jowar">Jowar</option>
                                            <option value="jute">Jute</option>
                                            <option value="lentil">Lentil</option>
                                            <option value="maize">Maize</option>
                                            <option value="moong">Moong</option>
                                            <option value="ragi">Ragi</option>
                                            <option value="rice">Rice</option>
                                            <option value="soyabean">Soyabean</option>
                                            <option value="urad">Urad</option>
                                            <option value="wheat">Wheat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-control-label">Quantity (in Quintals)</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-weight-hanging text-success"></i></span>
                                        </div>
                                        <input type="number" name="trade_farmer_cropquantity" class="form-control" placeholder="e.g. 50" min="1" step="0.01" required>
                                    </div>
                                    <small class="text-muted">1 Quintal = 100 KG</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-control-label">Price per Quintal (₹)</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign text-success"></i></span>
                                        </div>
                                        <input type="number" name="trade_farmer_cost" id="trade_farmer_cost" class="form-control" placeholder="e.g. 2500" min="1" required>
                                    </div>
                                    <small class="text-muted font-italic">Auto-filled based on market avg.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-control-label">Upload Crop Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="crop_image" id="crop_image" accept="image/*" required onchange="previewImage(event)">
                                        <label class="custom-file-label" for="crop_image">Select file...</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-control-label">Crop Information / Description</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-edit text-success"></i></span>
                                        </div>
                                        <textarea name="trade_farmer_cropinfo" class="form-control" rows="3" placeholder="Describe quality, variety (e.g. Lokwan Wheat), or organic details..." required></textarea>
                                    </div>
                                    <small class="text-muted">Mention specific details to attract more buyers.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4">
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body p-2 text-center bg-white rounded">
                                        <span class="d-block small text-muted mb-2 font-weight-bold">Image Preview</span>
                                        <img id="preview" src="../assets/img/agri.png" alt="Preview" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="Crop_submit" value="Crop_submit" class="btn btn-success btn-lg shadow-lg px-5">
                                <i class="fas fa-check-circle"></i> List Stock
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require("footer.php");?>

<script>
// 1. AJAX: Fetch Market Price
document.getElementById("crops").addEventListener("change", function() {
    var crops = jQuery('#crops').val();
    document.getElementById("crop_name_display").innerHTML = crops;
    
    if(crops){
        jQuery.ajax({
            url: 'fcheck_price.php',
            type: 'post',
            data: 'crops=' + crops,
            success: function(response) {
                // Update Alert
                $('#price').text(response);
                $("#popup").fadeIn();
                
                // Auto-fill Input
                $('#trade_farmer_cost').val(response);
            }
        });
    } else {
        $("#popup").fadeOut();
        $('#trade_farmer_cost').val('');
    }
});

// 2. JS: Image Preview
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    
    // Update filename in label
    var fileName = event.target.files[0].name;
    $('.custom-file-label').html(fileName);
}
</script>
</body>
</html>
<?php
include ('csession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['customer_login_user'])){
    header("location: ../index.php");
    exit();
}

$user_check = $_SESSION['customer_login_user'];

if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query4 = "SELECT * from custlogin where email='$user_check'";
} else {
    $query4 = "SELECT * from custlogin where phone_no='$user_check'";
}

$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);

if($row4) {
    $id = $row4['cust_id'];
    $name = $row4['cust_name'];
    $pic = !empty($row4['profile_pic']) ? $row4['profile_pic'] : 'default_cust.png';
} else {
    header("location: clogin.php");
    exit();
}

// UPDATE LOGIC
if(isset($_POST['custupdate'])) {
    $uid = $_POST['id'];
    $uname = mysqli_real_escape_string($conn, $_POST['name']);
    $uemail = mysqli_real_escape_string($conn, $_POST['email']);
    $umobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $ustate = $_POST['state'];
    $ucity = mysqli_real_escape_string($conn, $_POST['city']);
    $uaddress = mysqli_real_escape_string($conn, $_POST['address']);
    $upincode = $_POST['pincode'];
    
    $q_state = mysqli_query($conn, "SELECT StateName from state where StCode ='$ustate'");
    $r_state = mysqli_fetch_assoc($q_state);
    $statename = $r_state['StateName'];

    $update_img = "";
    if(!empty($_FILES['profile_pic']['name'])){
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $newname = "cust_".$uid."_".time().".".$ext;
        if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../assets/img/".$newname)){
            $update_img = ", profile_pic='$newname'";
        }
    }

    $sql = "UPDATE custlogin SET cust_name='$uname', email='$uemail', phone_no='$umobile', state='$statename', city='$ucity', address='$uaddress', pincode='$upincode' $update_img WHERE cust_id='$uid'";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Profile Updated Successfully'); window.location='cprofile.php';</script>";
    } else {
         echo "<script>alert('Error Updating Profile');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include ('cheader.php'); ?>
<head>
    <style>
        .profile-header {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../assets/img/market.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: white;
        }
        .card-profile-image img {
            max-width: 150px;
            border: 5px solid #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-top: -75px;
        }
        .info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8898aa;
            font-weight: bold;
        }
        .form-control-alternative {
            border: 0;
            transition: box-shadow .15s ease;
            box-shadow: 0 1px 3px rgba(50,50,93,.15), 0 1px 0 rgba(0,0,0,.02);
            background-color: #fff;
        }
    </style>
</head>

<body class="bg-light">
<?php include ('cnav.php'); ?>

<div class="profile-header text-center">
    <div class="container">
        <h1 class="display-2 text-white">Welcome, <?php echo $name; ?></h1>
        <p class="lead">Personalize your profile and manage your orders easily.</p>
        <button type="button" class="btn btn-warning px-5 shadow" data-toggle="modal" data-target="#editModal">
            <i class="fas fa-edit mr-2"></i> Edit Account
        </button>
    </div>
</div>

<div class="container mt-5 pb-5">
    <div class="row">
        <div class="col-xl-4 mb-5">
            <div class="card card-profile shadow border-0 text-center">
                <div class="card-profile-image">
                    <img src="../assets/img/<?php echo $pic; ?>" class="rounded-circle bg-white">
                </div>
                <div class="card-body pt-4">
                    <div class="mt-3">
                        <h3 class="mb-0"><?php echo $name; ?> <i class="fas fa-check-circle text-primary small"></i></h3>
                        <div class="h6 font-weight-300 text-muted">
                            <i class="fas fa-map-marker-alt mr-2"></i><?php echo $row4['city'] . ", " . $row4['state']; ?>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading text-success">Active</span>
                                    <span class="description">Status</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <h3 class="mb-0"><i class="fas fa-id-card mr-2 text-warning"></i> Account Details</h3>
                </div>
                <div class="card-body">
                    <div class="pl-lg-4">
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label class="info-label">Full Name</label>
                                <div class="p-3 bg-light rounded"><i class="fas fa-user mr-2 text-muted"></i> <?php echo $row4['cust_name']; ?></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="info-label">Email Address</label>
                                <div class="p-3 bg-light rounded"><i class="fas fa-envelope mr-2 text-muted"></i> <?php echo $row4['email']; ?></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label class="info-label">Mobile Number</label>
                                <div class="p-3 bg-light rounded"><i class="fas fa-phone mr-2 text-muted"></i> <?php echo $row4['phone_no']; ?></div>
                            </div>
                        </div>
                    </div>

                    <h6 class="heading-small text-muted mb-4 mt-5">Shipping Address</h6>
                    <div class="pl-lg-4">
                        <div class="form-group mb-4">
                            <label class="info-label">Home Address</label>
                            <div class="p-3 bg-light rounded"><i class="fas fa-home mr-2 text-muted"></i> <?php echo $row4['address']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="info-label">City</label>
                                <div class="p-3 bg-light rounded"><?php echo $row4['city']; ?></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="info-label">State</label>
                                <div class="p-3 bg-light rounded"><?php echo $row4['state']; ?></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="info-label">Postal Code</label>
                                <div class="p-3 bg-light rounded"><?php echo $row4['pincode']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title text-white"><i class="fas fa-user-edit mr-2"></i> Update Your Information</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Mobile</label>
                            <input type="number" name="mobile" class="form-control" value="<?php echo $row4['phone_no']; ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $row4['email']; ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Profile Picture</label>
                            <div class="custom-file">
                                <input type="file" name="profile_pic" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose photo</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?php echo $row4['address']; ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 form-group">
                             <label class="font-weight-bold">State</label>
                             <select onChange="getdistrict(this.value);" name="state" class="form-control" required>
                                 <option value="">Select State</option>
                                 <?php 
                                    $q=mysqli_query($conn,"SELECT * FROM state"); 
                                    while($r=mysqli_fetch_array($q)){ 
                                        echo "<option value='".$r['StCode']."'>".$r['StateName']."</option>"; 
                                    } 
                                 ?>
                             </select>
                        </div>
                        <div class="col-md-4 form-group">
                             <label class="font-weight-bold">City</label>
                             <select name="city" id="district-list" class="form-control">
                                <option value="<?php echo $row4['city']; ?>"><?php echo $row4['city']; ?></option>
                             </select>
                        </div>
                        <div class="col-md-4 form-group">
                             <label class="font-weight-bold">Pincode</label>
                             <input type="text" name="pincode" class="form-control" value="<?php echo $row4['pincode']; ?>">
                        </div>
                    </div>
                    
                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="custupdate" class="btn btn-warning px-4">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>

<script>
    // Custom File Input Label Update
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    function getdistrict(val) {
      $.ajax({
        type: "POST",
        url: "cget_district.php",
        data:'state_id='+val,
        success: function(data){
          $("#district-list").html(data);
        }
      });
    }
</script>
</body>
</html>
<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

$user_check = $_SESSION['farmer_login_user'];
// Safe Query
if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query4 = "SELECT * from farmerlogin where email='$user_check'";
} else {
    $query4 = "SELECT * from farmerlogin where phone_no='$user_check'";
}

$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);

if($row4) {
    $id = $row4['farmer_id'];
    $name = $row4['farmer_name'];
    // Use stored pic or default
    $pic = !empty($row4['F_profile_pic']) ? $row4['F_profile_pic'] : 'default_avatar.png'; 
    
    // FIX FOR WARNING: Map $name to $para2 because fnav.php uses $para2
    $para2 = $name; 
} else {
    header("location: flogin.php");
    exit();
}

// UPDATE LOGIC
if(isset($_POST['update_profile'])) {
    $uname = mysqli_real_escape_string($conn, $_POST['name']);
    $umobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $uemail = mysqli_real_escape_string($conn, $_POST['email']);
    // Check if keys exist before accessing to prevent errors
    $ugender = isset($_POST['gender']) ? $_POST['gender'] : $row4['F_gender'];
    $udob = $_POST['dob'];
    $ustate = $_POST['state'];
    $ucity = mysqli_real_escape_string($conn, $_POST['city']);
    
    // Get District (Handle the dropdown logic)
    $udistrict = isset($_POST['district']) ? $_POST['district'] : $row4['F_District'];

    // Get State Name
    if(!empty($ustate)){
        $q_state = mysqli_query($conn, "SELECT StateName from state where StCode ='$ustate'");
        $r_state = mysqli_fetch_assoc($q_state);
        $sname = $r_state['StateName'];
    } else {
        $sname = $row4['F_State'];
    }
    
    // Image Upload
    $update_img = "";
    if(!empty($_FILES['profile_pic']['name'])){
        $target_dir = "../assets/img/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }

        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $newname = "farmer_".$id."_".time().".".$ext;
        if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_dir.$newname)){
            $update_img = ", F_profile_pic='$newname'";
        }
    }

    $sql = "UPDATE farmerlogin SET farmer_name='$uname', email='$uemail', phone_no='$umobile', F_gender='$ugender', F_birthday='$udob', F_State='$sname', F_District='$udistrict', F_Location='$ucity' $update_img WHERE farmer_id='$id'";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Profile Updated Successfully'); window.location='fprofile.php';</script>";
    } else {
        echo "<script>alert('Error Updating Profile: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<?php include ('fheader.php'); ?>
<body class="bg-light">
<?php include ('fnav.php'); ?>

<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 400px; background-image: url(../assets/img/agri.png); background-size: cover; background-position: center top;">
  <span class="mask bg-gradient-success opacity-8"></span>
  <div class="container-fluid d-flex align-items-center">
    <div class="row">
      <div class="col-lg-7 col-md-10">
        <h1 class="display-2 text-white">Hello, <?php echo $name; ?></h1>
        <p class="text-white mt-0 mb-5">This is your profile page. You can check your details and edit your account information here.</p>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal">Edit Profile</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
      <div class="card card-profile shadow">
        <div class="row justify-content-center">
          <div class="col-lg-3 order-lg-2">
            <div class="card-profile-image">
              <a href="#">
                <?php 
                    $imagePath = "../assets/img/" . $pic;
                    if(!file_exists($imagePath)) { $imagePath = "https://via.placeholder.com/150"; }
                ?>
                <img src="<?php echo $imagePath; ?>" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid white;">
              </a>
            </div>
          </div>
        </div>
        <div class="card-body pt-0 pt-md-4">
          <div class="text-center mt-md-5 pt-md-5">
            <h3><?php echo $name; ?></h3>
            <div class="h5 font-weight-300">
              <i class="ni location_pin mr-2"></i><?php echo $row4['F_Location'] . ", " . $row4['F_District']; ?>
            </div>
            <div class="h5 mt-4">
              <i class="ni business_briefcase-24 mr-2"></i>Farmer - SmartKrushi Member
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-8 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">My Account</h3>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form>
            <h6 class="heading-small text-muted mb-4">User Information</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Username</label>
                    <input type="text" class="form-control form-control-alternative" value="<?php echo $row4['farmer_name']; ?>" readonly>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Email address</label>
                    <input type="email" class="form-control form-control-alternative" value="<?php echo $row4['email']; ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Mobile</label>
                    <input type="text" class="form-control form-control-alternative" value="<?php echo $row4['phone_no']; ?>" readonly>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Birthday</label>
                    <input type="text" class="form-control form-control-alternative" value="<?php echo $row4['F_birthday']; ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
            
            <hr class="my-4" />
            <h6 class="heading-small text-muted mb-4">Location Info</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">State</label>
                    <input type="text" class="form-control form-control-alternative" value="<?php echo $row4['F_State']; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">District</label>
                    <input type="text" class="form-control form-control-alternative" value="<?php echo $row4['F_District']; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">City</label>
                    <input type="text" class="form-control form-control-alternative" value="<?php echo $row4['F_Location']; ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        </div>
                         <div class="col-md-6 form-group">
                            <label>Mobile</label>
                            <input type="number" name="mobile" class="form-control" value="<?php echo $row4['phone_no']; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $row4['email']; ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control">
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-4 form-group">
                             <label>State (Select Again)</label>
                             <select onChange="getdistrict(this.value);" name="state" class="form-control">
                                 <option value="">Select State</option>
                                 <?php $q=mysqli_query($conn,"SELECT * FROM state"); while($r=mysqli_fetch_array($q)){ echo "<option value='".$r['StCode']."'>".$r['StateName']."</option>"; } ?>
                             </select>
                        </div>
                         <div class="col-md-4 form-group">
                             <label>District</label>
                             <select name="district" id="district-list" class="form-control"><option value="<?php echo $row4['F_District']; ?>"><?php echo $row4['F_District']; ?></option></select>
                        </div>
                         <div class="col-md-4 form-group">
                             <label>City</label>
                             <input type="text" name="city" class="form-control" value="<?php echo $row4['F_Location']; ?>">
                        </div>
                    </div>
                    
                    <input type="hidden" name="dob" value="<?php echo $row4['F_birthday']; ?>">
                    <input type="hidden" name="gender" value="<?php echo $row4['F_gender']; ?>">
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>
<script>
    function getdistrict(val) {
      $.ajax({
        type: "POST",
        url: "fget_district.php",
        data:'state_id='+val,
        success: function(data){
          $("#district-list").html(data);
        }
      });
    }
</script>
</body>
</html>
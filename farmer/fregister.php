<?php
include('fregisterScript.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="../assets/img/logo.png" />
  <title>Farmer Registration - SmartKrushi</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/creativetim.min.css" type="text/css">

  <style>
      .bg-register {
          background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/img/agri.png');
          background-size: cover;
          background-position: center;
          min-height: 100vh;
      }
      .card-register {
          background: rgba(255, 255, 255, 0.95);
          border: none;
          box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      }
      /* Style for the eye icon */
      .input-group-text {
          background-color: transparent;
          border-left: none;
          cursor: pointer;
      }
      /* Ensure the input border matches seamlessly */
      .form-control-password {
          border-right: none;
      }
      .form-control-password:focus {
          border-color: #ced4da;
          box-shadow: none;
      }
      /* Green focus for Farmer Theme */
      .input-group:focus-within .form-control-password, 
      .input-group:focus-within .input-group-text {
          border-color: #2dce89; 
          box-shadow: 0 0 0 0.2rem rgba(45, 206, 137, 0.25);
      }
  </style>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
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
</head>

<body class="bg-register">

<nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100 z-index-1">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="../index.php">SmartKrushi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-reg">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-reg">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="flogin.php" class="nav-link">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper pt-7 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-register">
                    <div class="card-header bg-success text-center py-4">
                        <h4 class="text-white mb-0"><i class="fas fa-tractor"></i> Farmer Registration</h4>
                        <p class="text-white-50 mb-0">Join the SmartKrushi Community</p>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        
                        <form name="insert" action="" method="post" enctype="multipart/form-data">
                            <div id="success"> <?php echo $error; ?> </div>

                            <h6 class="heading-small text-muted mb-4">Personal Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Full Name</label>
                                        <input class="form-control" type="text" name="name" placeholder="Ex: Ramesh Kumar" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Date of Birth</label>
                                        <input class="form-control" type="date" name="dob" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Email Address</label>
                                        <input class="form-control" type="email" name="email" placeholder="ramesh@example.com" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Mobile Number</label>
                                        <input class="form-control" type="number" name="mobile" placeholder="9876543210" required pattern="[6789][0-9]{9}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Profile Photo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="profile_pic" id="profile_pic" accept="image/*">
                                            <label class="custom-file-label" for="profile_pic">Choose photo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="heading-small text-muted mb-4 mt-4">Location Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">State</label>
                                        <select onChange="getdistrict(this.value);" name="state" id="state" class="form-control" required>
                                            <option value="">Select State</option>
                                            <?php
                                                $query = mysqli_query($conn,"SELECT * FROM state");
                                                while($row=mysqli_fetch_array($query)) {
                                                    echo '<option value="'.$row['StCode'].'">'.$row['StateName'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">District</label>
                                        <select name="district" id="district-list" class="form-control" required>
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">City / Village</label>
                                        <input class="form-control" type="text" name="city" required />
                                    </div>
                                </div>
                            </div>

                            <h6 class="heading-small text-muted mb-4 mt-4">Security</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Password</label>
                                        <div class="input-group">
                                            <input name="password" id="password" type="password" class="form-control form-control-password" placeholder="Create Password" required />
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('password', 'icon-pass')">
                                                    <i class="fas fa-eye" id="icon-pass"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input name="confirmpassword" id="confirmpassword" type="password" class="form-control form-control-password" placeholder="Confirm Password" required />
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('confirmpassword', 'icon-cpass')">
                                                    <i class="fas fa-eye" id="icon-cpass"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="farmerregister" class="btn btn-success btn-lg px-5">Create Account</button>
                            </div>
                            
                            <div class="text-center mt-3">
                                <small>Already have an account? <a href="flogin.php" class="text-success font-weight-bold">Login here</a></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    // Update file input label
    $('.custom-file-input').on('change', function() { 
       let fileName = $(this).val().split('\\').pop(); 
       $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });

    // PASSWORD TOGGLE FUNCTION
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash"); 
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye"); 
        }
    }
</script>
</body>
</html>
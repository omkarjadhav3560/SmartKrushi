<?php
include('floginScript.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="../assets/img/logo.png" />
  <title>Farmer Login - SmartKrushi</title>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel="stylesheet" href="../assets/css/creativetim.min.css" type="text/css">

  <style>
      .bg-login {
          background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../assets/img/harvest.jpg'); 
          /* Make sure you have an image named harvest.jpg or agri.png in assets/img */
          background-size: cover;
          background-position: center;
          height: 100vh;
          display: flex;
          align-items: center;
      }
      .card-login {
          border: none;
          border-radius: 1rem;
          box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
          overflow: hidden;
      }
      .login-header {
          background: #2dce89; /* Agri Green */
          color: white;
      }
  </style>
</head>

<body class="bg-login">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            
            <div class="text-center text-white mb-4">
                <h2 class="font-weight-bold">SmartKrushi</h2>
                <p>Welcome back, Farmer!</p>
            </div>

            <div class="card card-login">
                <div class="card-header login-header text-center pt-4 pb-4">
                    <h4 class="text-white mb-0">Login</h4>
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    
                    <form method="POST">
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email or Phone Number" type="text" name="farmer_email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input class="form-control" placeholder="Password" type="password" name="farmer_password" id="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer" onclick="togglePass()">
                                        <i class="fas fa-eye" id="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                            <label class="custom-control-label" for=" customCheckLogin">
                                <span class="text-muted">Remember me</span>
                            </label>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="farmerlogin" class="btn btn-success my-4 btn-block">Sign in</button>
                        </div>
                        
                        <div class="text-center mb-3">
                            <span class="text-muted">OR</span>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#otpModal">
                            <i class="fas fa-mobile-alt"></i> Login with OTP
                        </button>

                    </form>
                </div>
                <div class="card-footer bg-secondary text-center">
                     <div class="row">
                         <div class="col-6">
                             <a href="#" class="text-primary" data-toggle="modal" data-target="#forgotModal"><small>Forgot password?</small></a>
                         </div>
                         <div class="col-6 text-right">
                             <a href="fregister.php" class="text-primary"><small>Create new account</small></a>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login with OTP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
                <label>Enter Registered Mobile Number</label>
                <input type="number" class="form-control" placeholder="98XXXXXXXX">
            </div>
            <button type="button" class="btn btn-success btn-block" onclick="alert('In a real app, an SMS would be sent via API here.')">Send OTP</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Enter your email address and we'll send you a link to reset your password.</p>
        <form>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="name@example.com">
            </div>
            <button type="button" class="btn btn-warning btn-block" onclick="alert('Reset link sent! (Simulation)')">Send Reset Link</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function togglePass() {
        var x = document.getElementById("password");
        var y = document.getElementById("eye");
        if (x.type === "password") {
            x.type = "text";
            y.classList.remove("fa-eye");
            y.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            y.classList.remove("fa-eye-slash");
            y.classList.add("fa-eye");
        }
    }
</script>
</body>
</html>
<?php
include('aloginScript.php'); // Includes Login Script
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="../assets/img/logo.png" />
  <title>SmartKrushi - Admin Login</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/creativetim.min.css" type="text/css">

  <style>
    /* Match Homepage Header */
    .header-bg {
      background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
      padding-top: 150px;
      padding-bottom: 150px;
    }
    
    /* Floating Card Effect - FIXED Z-INDEX */
    .login-card {
      margin-top: -100px;
      border: 0;
      border-radius: 1rem;
      box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
      background-color: white;
      
      /* THIS FIXES THE BUTTON ISSUE */
      position: relative;
      z-index: 200; 
    }

    .form-control:focus {
        border-color: #2dce89;
    }
    
    .fa-eye, .fa-eye-slash {
        cursor: pointer;
    }

    /* Ensure the button is fully visible */
    .btn-submit {
        width: 100%;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
  </style>
</head>

<body class="bg-default">

  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-dark position-absolute w-100 z-index-100">
    <div class="container">
      <a class="navbar-brand mr-lg-5" href="../index.php">
        <h3 class="text-white font-weight-bold m-0"><i class="fas fa-leaf"></i> SmartKrushi</h3>
      </a>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbar_global">
        <ul class="navbar-nav navbar-nav-hover align-items-lg-center ml-auto">
          <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="../contact.php" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="header-bg">
    <div class="container text-center">
        <h1 class="text-white display-3 font-weight-bold">Admin Portal</h1>
        <p class="text-white mt-3">Secure access for system administrators only.</p>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
      <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
      </svg>
    </div>
  </div>

  <div class="container pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        
        <div class="card login-card bg-secondary shadow border-0">
          <div class="card-header bg-white pb-5">
            <div class="text-muted text-center mb-3"><small>Sign in with credentials</small></div>
            <div class="text-center">
                <img src="../assets/img/logo.png" style="width: 60px;"> 
            </div>
          </div>
          
          <div class="card-body px-lg-5 py-lg-5 bg-white">
            
            <?php if(!empty($error)) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <span class="alert-text"><strong>Error!</strong> <?php echo $error; ?></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

            <form role="form" method="POST">
              
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-shield text-success"></i></span>
                  </div>
                  <input class="form-control" placeholder="Admin ID / Email" type="text" name="admin_id" required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock text-success"></i></span>
                  </div>
                  <input class="form-control" placeholder="Password" type="password" name="admin_password" id="password-field" required>
                  <div class="input-group-append">
                    <span class="input-group-text" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggle-icon"></i>
                    </span>
                  </div>
                </div>
              </div>

              <div class="text-center">
                <button type="submit" name="adminlogin" class="btn btn-success btn-submit shadow">Sign in</button>
              </div>
            </form>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-6">
            <a href="../index.php" class="text-light"><small><i class="fas fa-arrow-left"></i> Back to Home</small></a>
          </div>
          <div class="col-6 text-right">
            <a href="#" class="text-light"><small>Forgot password?</small></a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php require("footer.php"); ?>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
      function togglePassword() {
          var passwordInput = document.getElementById("password-field");
          var toggleIcon = document.getElementById("toggle-icon");

          if (passwordInput.type === "password") {
              passwordInput.type = "text";
              toggleIcon.classList.remove("fa-eye");
              toggleIcon.classList.add("fa-eye-slash");
          } else {
              passwordInput.type = "password";
              toggleIcon.classList.remove("fa-eye-slash");
              toggleIcon.classList.add("fa-eye");
          }
      }
  </script>

</body>
</html>
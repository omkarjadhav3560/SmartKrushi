<?php
session_start();
include('sql.php'); // Database connection

$status = ""; // Variable to track success or failure

if (isset($_POST["submit"])) {
    // 1. Sanitize Inputs
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_mobile = mysqli_real_escape_string($conn, $_POST['user_mobile']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_address = mysqli_real_escape_string($conn, $_POST['user_address']);
    $user_message = mysqli_real_escape_string($conn, $_POST['user_message']);

    // 2. Insert Query
    $query = "INSERT INTO contactus (c_name, c_mobile, c_email, c_address, c_message) 
              VALUES ('$user_name', '$user_mobile', '$user_email', '$user_address', '$user_message')";

    if ($conn->query($query) === TRUE) {
        $status = "success";
    } else {
        $status = "error";
        $error_msg = $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="assets/img/logo.png" />
  <title>SmartKrushi - Contact Us</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  
  <link rel="stylesheet" href="assets/css/creativetim.min.css" type="text/css">
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />

  <style>
    /* 1. FIXED NAVBAR: Force it to stay at the top */
    .navbar-fixed-top {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1030; /* Higher than everything else */
    }

    /* 2. BODY PADDING: Push content down so navbar doesn't cover it */
    body {
        background-color: #f6f9fc; /* LIGHT BACKGROUND (Fixes Footer Text Visibility) */
        padding-top: 80px; 
    }

    /* 3. HEADER GRADIENT */
    .header-bg {
      background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
      padding-top: 60px;
      padding-bottom: 200px;
      position: relative;
    }
    
    /* 4. FLOATING CARD */
    .contact-card {
      margin-top: -160px;
      border: 0;
      border-radius: 1rem;
      box-shadow: 0 15px 35px rgba(50, 50, 93, .1), 0 5px 15px rgba(0, 0, 0, .07);
      position: relative; 
      z-index: 10; 
      background: white;
    }
    
    /* Input Styling */
    .input-group-text {
        background-color: #f8f9fe;
        border-color: #dee2e6;
    }
    .form-control {
        border-color: #dee2e6;
    }
    .form-control:focus {
        border-color: #2dce89;
        box-shadow: none;
    }
  </style>
</head>

<body>

<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-light navbar-fixed-top shadow py-2 bg-white">
  <div class="container">
    <a class="navbar-brand mr-lg-5" href="index.php">
      <h3 class="text-success font-weight-bold m-0"><i class="fas fa-leaf"></i> SmartKrushi</h3>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbar_global">
      <ul class="navbar-nav navbar-nav-hover align-items-lg-center ml-auto">
        
        <li class="nav-item"><a href="index.php" class="nav-link" id="nav-home">Home</a></li>
        <li class="nav-item"><a href="index.php#services" class="nav-link" id="nav-services">Services</a></li>
        <li class="nav-item"><a href="index.php#schemes" class="nav-link" id="nav-schemes">Schemes</a></li>
        <li class="nav-item"><a href="contact.php" class="nav-link text-success font-weight-bold" id="nav-contact"><i class="fas fa-envelope"></i> Contact</a></li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-toggle="dropdown">
             <i class="fas fa-language"></i> <span id="current-lang">English</span>
          </a>
          <div class="dropdown-menu">
              <a class="dropdown-item" href="#" onclick="setLanguage('en')">English</a>
              <a class="dropdown-item" href="#" onclick="setLanguage('hi')">हिन्दी (Hindi)</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle btn btn-success text-white btn-sm px-3 ml-3 shadow" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
             <i class="fas fa-user"></i> <span id="nav-account">Account</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <span class="dropdown-header">Login</span>
            <a class="dropdown-item" href="farmer/flogin.php">Farmer Login</a>
            <a class="dropdown-item" href="customer/clogin.php">Customer Login</a>
            <div class="dropdown-divider"></div>
            <span class="dropdown-header">Register</span>
            <a class="dropdown-item" href="farmer/fregister.php">New Farmer</a>
            <a class="dropdown-item" href="customer/cregister.php">New Customer</a>
            <div class="dropdown-divider"></div>
            <span class="dropdown-header">Admin Panel</span>
            <a class="dropdown-item text-danger" href="admin/alogin.php">
                <i class="fas fa-lock"></i> Admin Login
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="header-bg">
    <div class="container text-center">
        <h1 class="display-3 text-white font-weight-bold" id="hero-title">Let's talk about everything!</h1>
        <p class="text-white mt-3 lead" id="hero-desc">Have a question about crops, schemes, or the portal? We are here to help.</p>
    </div>
    
    <div class="separator separator-bottom separator-skew zindex-100">
      <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <polygon class="fill-default" points="2560 0 2560 100 0 100" style="fill: #f6f9fc;"></polygon>
      </svg>
    </div>
</div>

<section class="section pb-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        <div class="card contact-card">
          <div class="card-body px-lg-5 py-lg-5">
            
            <form action="" method="post">
                <h6 class="heading-small text-muted mb-4">Contact Information</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" id="lbl-name">Full Name</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user text-success"></i></span>
                                </div>
                                <input class="form-control" placeholder="e.g. Omkar Jadhav" type="text" name="user_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" id="lbl-mobile">Mobile Number</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone text-success"></i></span>
                                </div>
                                <input class="form-control" placeholder="e.g. 9876543210" type="text" name="user_mobile" pattern="[6-9]{1}[0-9]{9}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" id="lbl-email">Email Address</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope text-success"></i></span>
                                </div>
                                <input class="form-control" placeholder="name@example.com" type="email" name="user_email" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" id="lbl-address">City / Address</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt text-success"></i></span>
                                </div>
                                <input class="form-control" placeholder="e.g. Nanded, Maharashtra" type="text" name="user_address" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-control-label" id="lbl-message">Your Message</label>
                    <textarea class="form-control form-control-alternative" name="user_message" rows="4" placeholder="Type your message or query here..." required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-success btn-lg mt-4 w-50 shadow-lg" id="btn-submit">
                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                    </button>
                </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success"><i class="fas fa-check-circle"></i> Success</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Your message has been sent successfully! We will contact you shortly.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="window.location.href='index.php'">Go to Home</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Something went wrong. Please try again.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php if($status == "success") { ?>
    <script> $(document).ready(function(){ $('#successModal').modal('show'); }); </script>
<?php } elseif($status == "error") { ?>
    <script> $(document).ready(function(){ $('#errorModal').modal('show'); }); </script>
<?php } ?>

<script>
    const translations = {
        en: {
          navHome: "Home", navServices: "Services", navSchemes: "Schemes", navContact: "Contact", navAccount: "Account",
          heroTitle: "Let's talk about everything!",
          heroDesc: "Have a question about crops, schemes, or the portal? We are here to help.",
          lblName: "Full Name", lblMobile: "Mobile Number", lblEmail: "Email Address", lblAddress: "City / Address",
          lblMessage: "Your Message", btnSubmit: "Send Message"
        },
        hi: {
          navHome: "मुख्य पृष्ठ", navServices: "सेवाएं", navSchemes: "योजनाएं", navContact: "संपर्क", navAccount: "खाता",
          heroTitle: "आइए हर चीज़ पर बात करें!",
          heroDesc: "क्या आपके पास फसलों, योजनाओं या पोर्टल के बारे में कोई प्रश्न है? हम यहां मदद करने के लिए हैं।",
          lblName: "पूरा नाम", lblMobile: "मोबाइल नंबर", lblEmail: "ईमेल पता", lblAddress: "शहर / पता",
          lblMessage: "आपका संदेश", btnSubmit: "संदेश भेजें"
        }
    };

    function setLanguage(lang) {
        document.getElementById('current-lang').innerText = lang === 'en' ? 'English' : 'हिन्दी';
        document.getElementById('nav-home').innerText = translations[lang].navHome;
        document.getElementById('nav-services').innerText = translations[lang].navServices;
        document.getElementById('nav-schemes').innerText = translations[lang].navSchemes;
        document.getElementById('nav-contact').innerHTML = '<i class="fas fa-envelope"></i> ' + translations[lang].navContact;
        document.getElementById('nav-account').innerText = translations[lang].navAccount;
        
        document.getElementById('hero-title').innerText = translations[lang].heroTitle;
        document.getElementById('hero-desc').innerText = translations[lang].heroDesc;
        
        document.getElementById('lbl-name').innerText = translations[lang].lblName;
        document.getElementById('lbl-mobile').innerText = translations[lang].lblMobile;
        document.getElementById('lbl-email').innerText = translations[lang].lblEmail;
        document.getElementById('lbl-address').innerText = translations[lang].lblAddress;
        document.getElementById('lbl-message').innerText = translations[lang].lblMessage;
        document.getElementById('btn-submit').innerText = translations[lang].btnSubmit;
    }
</script>

</body>
</html>
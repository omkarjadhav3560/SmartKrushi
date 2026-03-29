<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartKrushi Footer Design</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <style>
        /* --- Footer Layout & Shape --- */
        .footer {
            background: #f4f5f7;
            position: relative;
            padding-top: 8rem; /* Space for the floating card */
            padding-bottom: 2rem;
            margin-top: 10rem; /* Push footer down from main content */
            clip-path: polygon(0 5%, 100% 0, 100% 100%, 0 100%); /* Slanted top edge */
        }

        /* --- Floating Card (Green Gradient) --- */
        .floating-card {
            margin-top: -12rem; /* Pulls the card upward */
            background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
            border-radius: 0.5rem;
            z-index: 2;
        }

        /* --- White Button (Inside Green Card) --- */
        .btn-white {
            background-color: #fff;
            color: #2dce89;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08);
            transition: all 0.2s ease;
        }
        .btn-white:hover {
            color: #233dd2;
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08);
        }

        /* --- Typography & Links --- */
        .footer .heading {
            color: #32325d;
            font-size: .9rem;
            text-transform: uppercase;
            letter-spacing: .05rem;
            font-weight: 600;
        }
        .footer-list li { margin-bottom: 0.6rem; }
        .footer-list a {
            color: #525f7f;
            font-size: .95rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .footer-list a:hover {
            color: #2dce89;
            padding-left: 5px;
        }
        .contact-list li {
            color: #525f7f;
            font-size: .9rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        /* --- Social Buttons (Floating Circles) --- */
        .btn-neutral {
            background-color: #fff;
            color: #5e72e4;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08);
            transition: all 0.3s ease;
        }
        .btn-neutral:hover {
            transform: translateY(-3px); /* Lift effect */
            box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08);
        }
        .btn-round { border-radius: 50%; }
        .btn-icon-only {
            width: 3rem;
            height: 3rem;
            padding: 0;
            line-height: 3rem;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        /* --- Brand Specific Colors on Hover --- */
        .btn-facebook { color: #3b5999; }
        .btn-facebook:hover { background-color: #3b5999; color: #fff; }

        .btn-twitter { color: #1da1f2; }
        .btn-twitter:hover { background-color: #1da1f2; color: #fff; }

        .btn-dribbble { color: #ea4c89; }
        .btn-dribbble:hover { background-color: #ea4c89; color: #fff; }

        .btn-github { color: #222; }
        .btn-github:hover { background-color: #222; color: #fff; }

        .btn-google { color: #dd4b39; }
        .btn-google:hover { background-color: #dd4b39; color: #fff; }

        /* --- Bottom Copyright Area --- */
        .copyright { font-size: .875rem; }
        .nav-footer .nav-link {
            color: #8898aa;
            font-size: .875rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .nav-footer .nav-link:hover { color: #32325d; }
    </style>
</head>
<body>

    <div style="min-height: 50vh; padding: 50px; text-align: center;">
        <h1>Welcome to SmartKrushi</h1>
        <p>Scroll down to see the footer.</p>
    </div>

    <footer class="footer has-cards">
        
        <div class="container container-lg">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card bg-gradient-success shadow-lg border-0 floating-card">
                        <div class="p-5">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h3 class="text-white"><i class="fas fa-seedling mr-2"></i> Soil Health Card Scheme</h3>
                                    <p class="lead text-white mt-3">"Swasth Dhara, Khet Hara" - Healthy Earth, Green Farm. Locate your nearest testing lab today.</p>
                                </div>
                                <div class="col-lg-4 ml-lg-auto">
                                    <a href="https://soilhealth.dac.gov.in/" target="_blank" class="btn btn-block btn-white">
                                        Track Soil Sample
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pt-5">
            <div class="row">
                
                <div class="col-lg-5 mb-5">
                    <h3 class="text-primary font-weight-light mb-2">Thank you for supporting farmers!</h3>
                    <h4 class="mb-4 font-weight-light text-muted" style="font-size: 1.1rem;">Let's grow together. Connect with us on social platforms.</h4>
                    
                    <div class="btn-wrapper">
                        <a target="_blank" href="https://twitter.com" class="btn btn-neutral btn-icon-only btn-twitter btn-round btn-lg" data-toggle="tooltip" title="Follow us">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a target="_blank" href="https://www.facebook.com" class="btn btn-neutral btn-icon-only btn-facebook btn-round btn-lg" data-toggle="tooltip" title="Like us">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                        <a target="_blank" href="https://dribbble.com" class="btn btn-neutral btn-icon-only btn-dribbble btn-lg btn-round" data-toggle="tooltip" title="Follow us">
                            <i class="fab fa-dribbble"></i>
                        </a>
                        <a target="_blank" href="https://github.com" class="btn btn-neutral btn-icon-only btn-github btn-round btn-lg" data-toggle="tooltip" title="Star on Github">
                            <i class="fab fa-github"></i>
                        </a>
                        <a target="_blank" href="mailto:barhmanandgaikwad@gmail.com" class="btn btn-neutral btn-icon-only btn-google btn-round btn-lg" data-toggle="tooltip" title="Email Us">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-lg-2 mb-4 offset-lg-1">
                    <h5 class="heading mb-3">Govt Links</h5>
                    <ul class="list-unstyled footer-list">
                        <li><a href="https://soilhealth.dac.gov.in/" target="_blank">SHC Portal</a></li>
                        <li><a href="https://agricoop.nic.in/" target="_blank">Min. of Agriculture</a></li>
                        <li><a href="https://farmer.gov.in/" target="_blank">Farmer Portal</a></li>
                        <li><a href="#">Kisan Call Center</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2 mb-4">
                    <h5 class="heading mb-3">Services</h5>
                    <ul class="list-unstyled footer-list">
                        <li><a href="#">Locate Testing Lab</a></li>
                        <li><a href="#">Print Health Card</a></li>
                        <li><a href="#">Fertilizer Calculator</a></li>
                        <li><a href="#">Crop Recommendations</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 mb-4">
                    <h5 class="heading mb-3">Contact</h5>
                    <ul class="list-unstyled contact-list">
                        <li>
                            <i class="fas fa-map-marker-alt text-primary mr-2 mt-1"></i>
                            <span>Bramhanand Nagar, Nanded</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt text-primary mr-2 mt-1"></i>
                            <span>+91 98765 43210</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4">

            <div class="row align-items-center justify-content-md-between pb-4">
                <div class="col-md-6">
                    <div class="copyright text-muted">
                        &copy; <?php echo date("Y"); ?> 
                        <a href="../index.php" class="font-weight-bold ml-1" target="_blank">SmartKrushi Portal</a>. 
                        All rights reserved.
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav nav-footer justify-content-end">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link" target="_blank">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="../contact.php" class="nav-link" target="_blank">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" target="_blank">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>
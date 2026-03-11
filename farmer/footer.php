<style>
    .footer-main {
        background: #f8f9fe;
        padding: 80px 0 40px;
        border-top: 1px solid #e9ecef;
    }
    
    .footer-heading {
        color: #32325d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        margin-bottom: 25px;
    }
    
    .footer-link {
        color: #8898aa !important;
        font-size: 0.95rem;
        display: block;
        margin-bottom: 12px;
        transition: all 0.3s;
        text-decoration: none !important;
    }
    
    .footer-link:hover {
        color: #2dce89 !important;
        padding-left: 8px;
    }

    .contact-info i {
        width: 30px;
        color: #2dce89;
    }

    .social-icon {
        width: 45px;
        height: 45px;
        background: white;
        color: #525f7f;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .social-icon:hover {
        background: #2dce89;
        color: white;
        transform: translateY(-5px);
    }

    .copyright {
        border-top: 1px solid #e9ecef;
        padding-top: 30px;
        margin-top: 50px;
        font-size: 0.9rem;
        color: #adb5bd;
    }
</style>

<footer class="footer-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                <h4 class="text-success font-weight-bold mb-3">SmartKrushi</h4>
                <p class="text-muted">A comprehensive digital ecosystem for modern agriculture, connecting farmers with AI-driven technology and market intelligence.</p>
                <div class="mt-4">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-5 mb-lg-0 pl-lg-5">
                <h5 class="footer-heading">Insights</h5>
                <a href="fcrop_prediction.php" class="footer-link">Crop Yield</a>
                <a href="fyield_prediction.php" class="footer-link">Harvest Prediction</a>
                <a href="frainfall_prediction.php" class="footer-link">Rainfall Analysis</a>
            </div>

            <div class="col-lg-2 col-md-6 mb-5 mb-lg-0 pl-lg-4">
                <h5 class="footer-heading">Services</h5>
                <a href="fcrop_recommendation.php" class="footer-link">Crop Selection</a>
                <a href="ffertilizer_recommendation.php" class="footer-link">Soil Health</a>
            </div>

            <div class="col-lg-5 col-md-6 mb-5 mb-lg-0 pl-lg-5">
                <h5 class="footer-heading">Contact Support</h5>
                <div class="contact-info">
                    <p class="text-muted mb-2"><i class="fas fa-map-marker-alt"></i> Bramhanand Nagar, Kalhali, Nanded, Maharashtra</p>
                    <p class="text-muted mb-2"><i class="fas fa-phone-alt"></i> +91 7420962566</p>
                    <p class="text-muted mb-4"><i class="fas fa-envelope"></i> barhmanandgaikwad@gmail.com</p>
                </div>
                <div class="btn-group shadow-sm rounded-pill">
                    <a href="tel:+917420962566" class="btn btn-outline-success px-4"><i class="fa fa-phone mr-2"></i> Call</a>
                    <a href="mailto:barhmanandgaikwad@gmail.com" class="btn btn-success px-4"><i class="fa fa-envelope mr-2"></i> Email</a>
                </div>
            </div>
        </div>

        <div class="row copyright">
            <div class="col-md-6 text-center text-md-left">
                &copy; <?php echo date('Y'); ?> <span class="text-success font-weight-bold">Agriculture Portal</span>. All rights reserved.
            </div>
            <div class="col-md-6 text-center text-md-right mt-3 mt-md-0">
                <a href="#" class="text-muted mr-3">Privacy Policy</a>
                <a href="#" class="text-muted">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
// Fix for "Undefined variable $para2" - ensures navbar always has a name to display
if (!isset($para2)) {
    $para2 = isset($_SESSION['admin_login_user']) ? $_SESSION['admin_login_user'] : 'Admin';
}
?>

<nav class="navbar navbar-main navbar-expand-lg navbar-dark bg-gradient-success sticky-top shadow-sm py-2">
  <div class="container-fluid px-lg-5">
    
    <a class="navbar-brand d-flex align-items-center" href="aprofile.php">
       <a class="navbar-brand" href="index.php">
            <i class="fas fa-leaf mr-2"></i> SmartKrushi
        </a>

    </a>

    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbar_global">
      <ul class="navbar-nav align-items-lg-center ml-auto" id="nav-links">
        
        <li class="nav-item">
          <a href="aprofile.php" class="nav-link">
            <i class="fas fa-home mr-1 text-white-50"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a href="afarmers.php" class="nav-link">
            <i class="fas fa-tractor mr-1 text-white-50"></i> Farmers
          </a>
        </li>

        <li class="nav-item">
          <a href="acustomers.php" class="nav-link">
            <i class="fas fa-users mr-1 text-white-50"></i> Customers
          </a>
        </li>

        <li class="nav-item">
          <a href="aproducedcrop.php" class="nav-link">
            <i class="fas fa-leaf mr-1 text-white-50"></i> Stock
          </a>
        </li>

        <li class="nav-item">
          <a href="amanage_orders.php" class="nav-link">
            <i class="fas fa-shipping-fast mr-1 text-white-50"></i> Orders
          </a>
        </li>

        <li class="nav-item">
          <a href="adelivery_partners.php" class="nav-link">
            <i class="fas fa-truck mr-1 text-white-50"></i> Drivers
          </a>
        </li>

        <li class="nav-item">
          <a href="aviewmsg.php" class="nav-link">
            <i class="fas fa-envelope mr-1 text-white-50"></i> Queries
          </a>
        </li>

        <li class="nav-item dropdown ml-lg-3">
          <a href="#" class="nav-link dropdown-toggle profile-dropdown-pill" data-toggle="dropdown" role="button">
            <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle bg-white text-success font-weight-bold mr-2">
                    <?php echo strtoupper(substr($para2, 0, 1)); ?>
                </span>
                <span class="mb-0 text-sm font-weight-bold d-none d-lg-inline-block"><?php echo htmlspecialchars($para2); ?></span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow shadow-lg border-0 mt-3 animate slideIn">
            <h6 class="dropdown-header text-uppercase text-muted tracking-wider">Control Panel</h6>
            <a href="aprofile.php" class="dropdown-item py-2">
              <i class="fas fa-id-card text-info mr-2"></i> My Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="alogout.php" class="dropdown-item py-2 text-danger">
              <i class="fas fa-power-off mr-2"></i> Sign Out
            </a>
          </div>
        </li>

      </ul>
    </div>
  </div>
</nav>

<style>
  .brand-text {
    letter-spacing: 2px;
    font-size: 1.25rem;
    color: #fff;
  }

  .sticky-top {
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    z-index: 1000;
  }

  .bg-gradient-success {
    background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
  }

  .navbar-nav .nav-link {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem 1rem !important;
    border-radius: 10px;
    transition: all 0.25s ease;
    color: rgba(255,255,255,0.85) !important;
  }

  .navbar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #fff !important;
  }

  /* Active Link styling */
  .navbar-nav .nav-item.active .nav-link {
    background: #ffffff !important;
    color: #2dce89 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }
  
  .navbar-nav .nav-item.active .nav-link i {
    color: #2dce89 !important;
  }

  .avatar-sm {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .profile-dropdown-pill {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 30px;
    padding: 5px 15px !important;
  }

  .animate.slideIn {
    animation-duration: 0.3s;
    animation-fill-mode: both;
    animation-name: slideIn;
  }

  @keyframes slideIn {
    0% { transform: translateY(1rem); opacity: 0; }
    100% { transform: translateY(0rem); opacity: 1; }
  }
</style>

<script>
  $(document).ready(function() {
    // Logic to highlight the active menu item based on current page
    var currentUrl = window.location.pathname.split('/').pop();
    if (currentUrl === "") currentUrl = "aprofile.php"; 

    $('#nav-links .nav-link').each(function() {
        var linkUrl = $(this).attr('href');
        if (currentUrl === linkUrl) {
            $(this).closest('.nav-item').addClass('active');
        }
    });
  });
</script>
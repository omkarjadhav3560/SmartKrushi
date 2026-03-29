<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="assets/img/logo.png" />
  <title>SmartKrushi - The Future of Farming</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/creativetim.min.css" type="text/css">

  <style>
    /* Custom Styles for Realism */
    .market-ticker {
        background: #2dce89;
        color: white;
        padding: 10px 0;
        font-weight: bold;
        white-space: nowrap;
        overflow: hidden;
        position: relative;
    }
    .market-ticker span {
        display: inline-block;
        padding-left: 100%;
        animation: ticker 30s linear infinite;
    }
    @keyframes ticker {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-100%, 0, 0); }
    }
    .service-card {
        transition: transform 0.3s;
        cursor: pointer;
    }
    .service-card:hover {
        transform: translateY(-10px);
    }
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/img/agri.png');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 150px 0;
    }
  </style>
</head>

<body class="bg-white" id="top">

  <div class="market-ticker">
      <span id="ticker-text">
          📢 LIVE APMC RATES: Wheat: ₹2,100/Qtl | Rice: ₹1,950/Qtl | Cotton: ₹6,400/Qtl | Soybean: ₹4,800/Qtl | Tur: ₹7,200/Qtl | Gram: ₹5,100/Qtl &nbsp;&nbsp;&nbsp;&nbsp; 🌦️ WEATHER ALERT: Heavy rains expected in Marathwada region next 48 hours.
      </span>
  </div>

  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-light position-sticky top-0 shadow py-2 bg-white">
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
          <li class="nav-item"><a href="#services" class="nav-link" id="nav-services">Services</a></li>
          <li class="nav-item"><a href="#schemes" class="nav-link" id="nav-schemes">Schemes</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link" id="nav-contact"><i class="fas fa-envelope"></i> Contact</a></li>
          
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
            <a class="nav-link dropdown-toggle btn btn-outline-success text-success btn-sm px-3 ml-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
               <i class="fas fa-user"></i> <span id="nav-account">Account</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <span class="dropdown-header" id="menu-login">Login</span>
              <a class="dropdown-item" href="farmer/flogin.php" id="menu-flogin">Farmer Login</a>
              <a class="dropdown-item" href="customer/clogin.php" id="menu-clogin">Customer Login</a>
              
              <div class="dropdown-divider"></div>
              <span class="dropdown-header" id="menu-register">Register</span>
              <a class="dropdown-item" href="farmer/fregister.php" id="menu-freg">New Farmer</a>
              <a class="dropdown-item" href="customer/cregister.php" id="menu-creg">New Customer</a>

              <div class="dropdown-divider"></div>
              <span class="dropdown-header">Admin Panel</span>
              <a class="dropdown-item text-danger" href="admin/alogin.php">
                  <i class="fas fa-lock"></i> <span id="menu-admin">Admin Login</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="wrapper">
    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-2 text-white font-weight-bold" id="hero-title">Empowering Farmers, <br>Feeding the Nation.</h1>
            <p class="lead text-white mt-3 mb-5" id="hero-desc">Access real-time market prices, expert crop advice, and direct-to-customer selling tools.</p>
            <a href="farmer/fregister.php" class="btn btn-success btn-lg btn-icon mb-3 mb-sm-0">
                <span class="btn-inner--icon"><i class="fas fa-tractor"></i></span>
                <span class="btn-inner--text" id="btn-farmer">I am a Farmer</span>
            </a>
            <a href="customer/cregister.php" class="btn btn-white btn-lg btn-icon mb-3 mb-sm-0 ml-lg-3">
                <span class="btn-inner--icon"><i class="fas fa-shopping-basket"></i></span>
                <span class="btn-inner--text" id="btn-customer">Buy Fresh Crops</span>
            </a>
        </div>
    </header>

    <div class="container mt--5">
        <div class="card bg-gradient-secondary shadow border-0">
            <div class="card-body py-4">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-lg icon-shape-success rounded-circle shadow mr-4">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div>
                        <h5 class="text-success text-uppercase mb-0" id="quote-title">Daily Inspiration</h5>
                        <p class="description mt-2 mb-0 italic" id="quote-display">
                            "The ultimate goal of farming is not the growing of crops, but the cultivation and perfection of human beings."
                        </p>
                        <small class="text-muted font-weight-bold" id="author-display">- Masanobu Fukuoka</small>
                    </div>
                    <button class="btn btn-sm btn-icon btn-success ml-auto" onclick="newQuote()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="section pb-0 bg-gradient-warning" id="services">
      <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="display-3 text-white" id="service-head">Our Smart Services</h2>
                <p class="lead text-white" id="service-sub">Everything a modern farmer needs to succeed in one portal.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 h-100 service-card">
                    <div class="card-body py-5 text-center">
                        <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h6 class="text-primary text-uppercase" id="s1-title">Market Analysis</h6>
                        <p class="description mt-3" id="s1-desc">Get daily MSP (Minimum Support Price) updates and market trends from nearby APMCs to sell at the right time.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 h-100 service-card">
                    <div class="card-body py-5 text-center">
                        <div class="icon icon-shape icon-shape-success rounded-circle mb-4">
                            <i class="fas fa-cloud-sun-rain"></i>
                        </div>
                        <h6 class="text-success text-uppercase" id="s2-title">Weather Forecast</h6>
                        <p class="description mt-3" id="s2-desc">Precision weather forecasting helps you plan sowing, irrigation, and harvesting to avoid losses.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 h-100 service-card">
                    <div class="card-body py-5 text-center">
                        <div class="icon icon-shape icon-shape-warning rounded-circle mb-4">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h6 class="text-warning text-uppercase" id="s3-title">Soil Health Card</h6>
                        <p class="description mt-3" id="s3-desc">Book soil testing labs and get digital reports recommending the perfect fertilizer dosage.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section>

    <section class="section section-lg" id="schemes">
        <div class="container">
            <div class="row row-grid align-items-center">
                <div class="col-md-6 order-md-2">
                    <img src="assets/img/features.png" class="img-fluid floating">
                </div>
                <div class="col-md-6 order-md-1">
                    <div class="pr-md-5">
                        <div class="icon icon-lg icon-shape icon-shape-danger shadow rounded-circle mb-5">
                            <i class="fas fa-university"></i>
                        </div>
                        <h3 id="scheme-head">Government Schemes & Support</h3>
                        <p id="scheme-sub">Stay updated with the latest subsidies and financial aid provided by the Government of India.</p>
                        <ul class="list-unstyled mt-5">
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div class="badge badge-circle badge-success mr-3"><i class="fas fa-check"></i></div>
                                    <div><h6 class="mb-0" id="sc1">PM-KISAN Samman Nidhi Yojana</h6></div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div class="badge badge-circle badge-success mr-3"><i class="fas fa-check"></i></div>
                                    <div><h6 class="mb-0" id="sc2">Pradhan Mantri Fasal Bima Yojana (Crop Insurance)</h6></div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div class="badge badge-circle badge-success mr-3"><i class="fas fa-check"></i></div>
                                    <div><h6 class="mb-0" id="sc3">Soil Health Card Scheme</h6></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php");?>

  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
      // 1. Quote Generator Logic
      const quotes = [
          { text: "The farmer is the only man in our economy who buys everything at retail, sells everything at wholesale, and pays the freight both ways.", author: "John F. Kennedy" },
          { text: "Agriculture is the most healthful, most useful and most noble employment of man.", author: "George Washington" },
          { text: "Farming looks mighty easy when your plow is a pencil and you're a thousand miles from the corn field.", author: "Dwight D. Eisenhower" },
          { text: "The discovery of agriculture was the first big step toward a civilized life.", author: "Arthur Keith" },
          { text: "Agriculture is our wisest pursuit, because it will in the end contribute most to real wealth, good morals, and happiness.", author: "Thomas Jefferson" }
      ];

      function newQuote() {
          const randomIndex = Math.floor(Math.random() * quotes.length);
          document.getElementById('quote-display').innerText = '"' + quotes[randomIndex].text + '"';
          document.getElementById('author-display').innerText = '- ' + quotes[randomIndex].author;
      }

      // 2. Multi-Language Logic (English / Hindi)
      const translations = {
          en: {
            navHome: "Home",
            navServices: "Services",
            navSchemes: "Schemes",
            navContact: "Contact",
            navAccount: "Account",
            
            menuLogin: "Login",
            menuFlogin: "Farmer Login",
            menuClogin: "Customer Login",
            menuRegister: "Register",
            menuFreg: "New Farmer",
            menuCreg: "New Customer",
            menuAdmin: "Admin Login",

            heroTitle: "Empowering Farmers, <br>Feeding the Nation.",
            heroDesc: "Access real-time market prices, expert crop advice, and direct-to-customer selling tools.",
            btnFarmer: "I am a Farmer",
            btnCustomer: "Buy Fresh Crops",

            quoteTitle: "Daily Inspiration",

            serviceHead: "Our Smart Services",
            serviceSub: "Everything a modern farmer needs to succeed in one portal.",
            
            s1Title: "Market Analysis",
            s1Desc: "Get daily MSP (Minimum Support Price) updates and market trends from nearby APMCs to sell at the right time.",
            
            s2Title: "Weather Forecast",
            s2Desc: "Precision weather forecasting helps you plan sowing, irrigation, and harvesting to avoid losses.",
            
            s3Title: "Soil Health Card",
            s3Desc: "Book soil testing labs and get digital reports recommending the perfect fertilizer dosage.",

            schemeHead: "Government Schemes & Support",
            schemeSub: "Stay updated with the latest subsidies and financial aid provided by the Government of India.",
            sc1: "PM-KISAN Samman Nidhi Yojana",
            sc2: "Pradhan Mantri Fasal Bima Yojana (Crop Insurance)",
            sc3: "Soil Health Card Scheme"
          },
          hi: {
            navHome: "मुख्य पृष्ठ",
            navServices: "सेवाएं",
            navSchemes: "योजनाएं",
            navContact: "संपर्क",
            navAccount: "खाता",
            
            menuLogin: "लॉग इन",
            menuFlogin: "किसान लॉग इन",
            menuClogin: "ग्राहक लॉग इन",
            menuRegister: "पंजीकरण",
            menuFreg: "नया किसान",
            menuCreg: "नया ग्राहक",
            menuAdmin: "एडमिन लॉग इन",

            heroTitle: "किसानों का सशक्तिकरण, <br>देश का पोषण।",
            heroDesc: "सही समय पर फसल बेचने के लिए मंडी भाव, विशेषज्ञ सलाह और सीधे ग्राहकों को बेचने की सुविधा।",
            btnFarmer: "मैं एक किसान हूँ",
            btnCustomer: "ताजी फसलें खरीदें",

            quoteTitle: "दैनिक प्रेरणा",

            serviceHead: "हमारी स्मार्ट सेवाएं",
            serviceSub: "एक आधुनिक किसान की सफलता के लिए सब कुछ एक ही जगह।",
            
            s1Title: "बाजार विश्लेषण",
            s1Desc: "न्यूनतम समर्थन मूल्य (MSP) और नजदीकी APMC मंडी के ताज़ा भाव प्राप्त करें।",
            
            s2Title: "मौसम पूर्वानुमान",
            s2Desc: "सटीक मौसम की जानकारी से बुवाई, सिंचाई और कटाई की योजना बनाएं और नुकसान से बचें।",
            
            s3Title: "मृदा स्वास्थ्य कार्ड",
            s3Desc: "मिट्टी परीक्षण लैब बुक करें और सही खाद की मात्रा जानने के लिए डिजिटल रिपोर्ट प्राप्त करें।",

            schemeHead: "सरकारी योजनाएं और सहायता",
            schemeSub: "भारत सरकार द्वारा दी जाने वाली नवीनतम सब्सिडी और वित्तीय सहायता से अपडेट रहें।",
            sc1: "पीएम-किसान सम्मान निधि योजना",
            sc2: "प्रधानमंत्री फसल बीमा योजना",
            sc3: "मृदा स्वास्थ्य कार्ड योजना"
          }
      };

      function setLanguage(lang) {
        // Update Navbar
        document.getElementById('current-lang').innerText = lang === 'en' ? 'English' : 'हिन्दी';
        document.getElementById('nav-home').innerText = translations[lang].navHome;
        document.getElementById('nav-services').innerText = translations[lang].navServices;
        document.getElementById('nav-schemes').innerText = translations[lang].navSchemes;
        document.getElementById('nav-contact').innerHTML = '<i class="fas fa-envelope"></i> ' + translations[lang].navContact;
        document.getElementById('nav-account').innerText = translations[lang].navAccount;
        
        // Update Menu
        document.getElementById('menu-login').innerText = translations[lang].menuLogin;
        document.getElementById('menu-flogin').innerText = translations[lang].menuFlogin;
        document.getElementById('menu-clogin').innerText = translations[lang].menuClogin;
        document.getElementById('menu-register').innerText = translations[lang].menuRegister;
        document.getElementById('menu-freg').innerText = translations[lang].menuFreg;
        document.getElementById('menu-creg').innerText = translations[lang].menuCreg;
        document.getElementById('menu-admin').innerText = translations[lang].menuAdmin;

        // Update Hero
        document.getElementById('hero-title').innerHTML = translations[lang].heroTitle;
        document.getElementById('hero-desc').innerText = translations[lang].heroDesc;
        document.getElementById('btn-farmer').innerText = translations[lang].btnFarmer;
        document.getElementById('btn-customer').innerText = translations[lang].btnCustomer;

        // Update Sections
        document.getElementById('quote-title').innerText = translations[lang].quoteTitle;
        document.getElementById('service-head').innerText = translations[lang].serviceHead;
        document.getElementById('service-sub').innerText = translations[lang].serviceSub;
        
        document.getElementById('s1-title').innerText = translations[lang].s1Title;
        document.getElementById('s1-desc').innerText = translations[lang].s1Desc;
        document.getElementById('s2-title').innerText = translations[lang].s2Title;
        document.getElementById('s2-desc').innerText = translations[lang].s2Desc;
        document.getElementById('s3-title').innerText = translations[lang].s3Title;
        document.getElementById('s3-desc').innerText = translations[lang].s3Desc;

        document.getElementById('scheme-head').innerText = translations[lang].schemeHead;
        document.getElementById('scheme-sub').innerText = translations[lang].schemeSub;
        document.getElementById('sc1').innerText = translations[lang].sc1;
        document.getElementById('sc2').innerText = translations[lang].sc2;
        document.getElementById('sc3').innerText = translations[lang].sc3;
      }
  </script>

</body>
</html>
<?php
include('fsession.php');
ini_set('memory_limit', '-1');

if (!isset($_SESSION['farmer_login_user'])) {
    header("location: ../index.php");
    exit();
}

$query4 = "SELECT * FROM farmerlogin WHERE email='$user_check'";
$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);

// Initialize variables to avoid undefined errors
$prediction_result = null;
$advisory = "";
$advisory_color = "";
$icon = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('fheader.php'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7f6;
            overflow-x: hidden;
        }

        /* Hero Background */
        .bg-header {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            height: 300px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        .main-container {
            margin-top: 100px;
            margin-bottom: 50px;
        }

        /* Card Styling */
        .dashboard-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .card-header-custom {
            background: white;
            padding: 25px;
            border-bottom: 1px solid #eee;
        }

        .form-control-lg {
            border-radius: 15px;
            border: 2px solid #eaecf4;
            font-size: 15px;
            height: 55px;
        }

        .form-control-lg:focus {
            border-color: #0061f2;
            box-shadow: none;
        }

        .btn-gradient {
            background: linear-gradient(45deg, #0061f2, #00c6f2);
            border: none;
            color: white;
            padding: 15px;
            border-radius: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(0, 97, 242, 0.4);
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 97, 242, 0.6);
            color: white;
        }

        /* Result Section Styles */
        .prediction-number {
            font-size: 4rem;
            font-weight: 700;
            background: -webkit-linear-gradient(#0061f2, #6900f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .advisory-box {
            background: #f8f9fa;
            border-left: 5px solid;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .advisory-success { border-color: #28a745; background: #e8f5e9; }
        .advisory-warning { border-color: #ffc107; background: #fff3cd; }
        .advisory-danger { border-color: #dc3545; background: #f8d7da; }

        .loader {
            display: none;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #0061f2;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>

<body>
    
    <div class="bg-header"></div>

    <?php include('fnav.php'); ?>

    <div class="container main-container">
        
        <div class="row mb-4">
            <div class="col-12 text-center text-white">
                <h1 class="font-weight-bold">Rainfall Intelligence</h1>
                <p style="opacity: 0.8;">AI-Powered precipitation forecasting for smarter farming</p>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-5 mb-4">
                <div class="dashboard-card h-100">
                    <div class="card-header-custom">
                        <h4 class="m-0 font-weight-bold text-dark"><i class="fas fa-sliders-h mr-2 text-primary"></i> Parameters</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" onsubmit="showLoader()">
                            
                            <div class="form-group mb-4">
                                <label class="text-xs font-weight-bold text-primary text-uppercase mb-1">Select Region</label>
                                <select name="region" class="form-control form-control-lg" required>
                                    <option value="">Choose State/Region...</option>
                                    <option value="ANDAMAN & NICOBAR ISLANDS">ANDAMAN & NICOBAR ISLANDS</option>
                                    <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                                    <option value="ASSAM & MEGHALAYA">ASSAM & MEGHALAYA</option>
                                    <option value="BIHAR">BIHAR</option>
                                    <option value="CHHATTISGARH">CHHATTISGARH</option>
                                    <option value="COASTAL ANDHRA PRADESH">COASTAL ANDHRA PRADESH</option>
                                    <option value="COASTAL KARNATAKA">COASTAL KARNATAKA</option>
                                    <option value="EAST MADHYA PRADESH">EAST MADHYA PRADESH</option>
                                    <option value="EAST RAJASTHAN">EAST RAJASTHAN</option>
                                    <option value="EAST UTTAR PRADESH">EAST UTTAR PRADESH</option>
                                    <option value="GANGETIC WEST BENGAL">GANGETIC WEST BENGAL</option>
                                    <option value="GUJARAT REGION">GUJARAT REGION</option>
                                    <option value="HARYANA DELHI & CHANDIGARH">HARYANA DELHI & CHANDIGARH</option>
                                    <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                                    <option value="JAMMU & KASHMIR">JAMMU & KASHMIR</option>
                                    <option value="JHARKHAND">JHARKHAND</option>
                                    <option value="KERALA">KERALA</option>
                                    <option value="KONKAN & GOA">KONKAN & GOA</option>
                                    <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                                    <option value="MADHYA MAHARASHTRA">MADHYA MAHARASHTRA</option>
                                    <option value="MATATHWADA">MATATHWADA</option>
                                    <option value="NAGA MANI MIZO TRIPURA">NAGA MANI MIZO TRIPURA</option>
                                    <option value="NORTH INTERIOR KARNATAKA">NORTH INTERIOR KARNATAKA</option>
                                    <option value="ORISSA">ORISSA</option>
                                    <option value="PUNJAB">PUNJAB</option>
                                    <option value="RAYALSEEMA">RAYALSEEMA</option>
                                    <option value="SAURASHTRA & KUTCH">SAURASHTRA & KUTCH</option>
                                    <option value="SOUTH INTERIOR KARNATAKA">SOUTH INTERIOR KARNATAKA</option>
                                    <option value="SUB HIMALAYAN WEST BENGAL & SIKKIM">SUB HIMALAYAN WEST BENGAL & SIKKIM</option>
                                    <option value="TAMIL NADU">TAMIL NADU</option>
                                    <option value="TELANGANA">TELANGANA</option>
                                    <option value="UTTARAKHAND">UTTARAKHAND</option>
                                    <option value="VIDARBHA">VIDARBHA</option>
                                    <option value="WEST MADHYA PRADESH">WEST MADHYA PRADESH</option>
                                    <option value="WEST RAJASTHAN">WEST RAJASTHAN</option>
                                    <option value="WEST UTTAR PRADESH">WEST UTTAR PRADESH</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label class="text-xs font-weight-bold text-primary text-uppercase mb-1">Select Month</label>
                                <select name="month" class="form-control form-control-lg" required>
                                    <option value="">Choose Month...</option>
                                    <option value="JAN">January</option>
                                    <option value="FEB">February</option>
                                    <option value="MAR">March</option>
                                    <option value="APR">April</option>
                                    <option value="MAY">May</option>
                                    <option value="JUN">June</option>
                                    <option value="JUL">July</option>
                                    <option value="AUG">August</option>
                                    <option value="SEP">September</option>
                                    <option value="OCT">October</option>
                                    <option value="NOV">November</option>
                                    <option value="DEC">December</option>
                                </select>
                            </div>

                            <button type="submit" name="Rainfall_Predict" class="btn btn-gradient btn-block btn-lg">
                                <i class="fas fa-rocket mr-2"></i> Run Prediction
                            </button>

                            <div id="loader" class="loader"></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <?php 
                if (isset($_POST['Rainfall_Predict'])) {
                    $region = trim($_POST['region']);
                    $month = trim($_POST['month']);
                    
                    $safeRegion = escapeshellarg($region);
                    $safeMonth = escapeshellarg($month);
                    
                    // --- BACKEND CONNECTION ---
                    $scriptPath = __DIR__ . "/ML/rainfall_prediction/rainfall_prediction.py";
                    $pythonExec = "python"; // Update this path if needed (e.g., C:\\Python39\\python.exe)
                    
                    $command = "$pythonExec \"$scriptPath\" $safeRegion $safeMonth 2>&1";
                    $output = shell_exec($command);
                    $prediction_result = floatval($output); // Convert to float for logic
                    
                    // --- SMART ADVISORY LOGIC ---
                    if($prediction_result < 50) {
                        $advisory = "<strong>Low Rainfall Alert:</strong> Rainfall is expected to be scanty. Ensure irrigation systems are ready. Suitable for drought-resistant crops.";
                        $advisory_color = "advisory-danger";
                        $icon = "fa-sun";
                        $chartColor = "#dc3545";
                    } elseif($prediction_result >= 50 && $prediction_result < 200) {
                        $advisory = "<strong>Moderate Rainfall:</strong> Conditions are optimal for most crops. Standard water management practices recommended.";
                        $advisory_color = "advisory-warning"; // Yellow/Orange
                        $icon = "fa-cloud-sun-rain";
                        $chartColor = "#ffc107";
                    } else {
                        $advisory = "<strong>Heavy Rainfall Alert:</strong> High precipitation expected. Ensure proper drainage fields to prevent waterlogging and fungal diseases.";
                        $advisory_color = "advisory-success"; // Green (Plenty of water) or Blue
                        $icon = "fa-umbrella";
                        $chartColor = "#0061f2";
                    }
                ?>

                <div class="dashboard-card mb-4 animate__animated animate__fadeInUp">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center border-right">
                                <h6 class="text-uppercase text-secondary mb-3">Predicted Rainfall</h6>
                                <div class="prediction-number"><?php echo $output; ?><span style="font-size: 20px; color: #666;">mm</span></div>
                                <div class="mt-2 text-muted"><i class="fas fa-map-marker-alt mr-1"></i> <?php echo $region; ?> | <?php echo $month; ?></div>
                            </div>
                            
                            <div class="col-md-6 pl-md-5 mt-3 mt-md-0">
                                <h5 class="font-weight-bold text-dark mb-3">Farming Advisory</h5>
                                <div class="advisory-box <?php echo $advisory_color; ?>">
                                    <i class="fas <?php echo $icon; ?> fa-2x mb-2 d-block"></i>
                                    <?php echo $advisory; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-dark">Visual Analysis</h6>
                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i> Report</button>
                    </div>
                    <div class="card-body">
                        <canvas id="rainfallChart" height="150"></canvas>
                    </div>
                </div>

                <script>
                    var ctx = document.getElementById('rainfallChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Predicted', 'Threshold (High)', 'Threshold (Low)'],
                            datasets: [{
                                label: 'Rainfall (mm)',
                                data: [<?php echo $prediction_result; ?>, 200, 50],
                                backgroundColor: [
                                    '<?php echo $chartColor; ?>',
                                    'rgba(200, 200, 200, 0.2)',
                                    'rgba(200, 200, 200, 0.2)'
                                ],
                                borderColor: [
                                    '<?php echo $chartColor; ?>',
                                    'rgba(200, 200, 200, 1)',
                                    'rgba(200, 200, 200, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: { beginAtZero: true }
                            },
                            responsive: true,
                            plugins: {
                                legend: { display: false },
                                title: { display: true, text: 'Rainfall Comparison' }
                            }
                        }
                    });
                </script>

                <?php 
                } else { 
                ?>
                    <div class="dashboard-card h-100 d-flex align-items-center justify-content-center text-center p-5">
                        <div>
                            <img src="https://cdn-icons-png.flaticon.com/512/1163/1163624.png" width="150" style="opacity: 0.5; margin-bottom: 20px;">
                            <h3 class="text-gray-500">Waiting for Data</h3>
                            <p class="text-muted">Select region and month to generate analysis.</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
        }
    </script>
</body>
</html>
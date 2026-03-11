<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

$query4 = "SELECT * from farmerlogin where email='$user_check'";
$ses_sq4 = mysqli_query($conn, $query4);
$row4 = mysqli_fetch_assoc($ses_sq4);
$para1 = $row4['farmer_id'];
$para2 = $row4['farmer_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('fheader.php'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1625246333195-5512a1d3c15d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
        }
        
        /* Dark overlay to make text pop */
        .overlay {
            background: rgba(0, 0, 0, 0.4);
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* Glassmorphism Card Design */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 40px;
            margin-top: 50px;
        }

        .form-control {
            border-radius: 10px;
            height: 50px;
            border: 1px solid #ddd;
            padding-left: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            border-color: #28a745;
        }

        .btn-predict {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            border: none;
            border-radius: 50px;
            padding: 12px 40px;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.2s;
            width: 100%;
        }

        .btn-predict:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .result-box {
            background: #e8f5e9;
            border-left: 5px solid #28a745;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
            animation: fadeIn 0.5s ease-in;
        }

        .page-title {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            font-weight: 700;
            margin-bottom: 10px;
        }

        /* Loading Spinner */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    
    <div class="overlay">
        <?php include ('fnav.php'); ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    
                    <div class="text-center mt-5 mb-4">
                        <h1 class="page-title display-4">AI Crop Prediction</h1>
                        <p class="text-white lead">Select your region and season to get smart farming recommendations.</p>
                    </div>

                    <div class="glass-card">
                        <div class="text-center mb-4">
                            <span class="badge badge-success badge-pill px-3 py-2">
                                <i class="fas fa-seedling mr-1"></i> ML Powered
                            </span>
                            <h3 class="mt-3 font-weight-bold text-dark">Enter Soil & Climate Details</h3>
                        </div>

                        <form role="form" action="#" method="post" id="predictionForm" onsubmit="showLoader()">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold text-muted">State</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0">
                                                <i class="fas fa-map-marker-alt text-success"></i>
                                            </span>
                                        </div>
                                        <select onchange="print_city('state', this.selectedIndex);" id="sts" name="stt" class="form-control border-left-0" required></select>
                                    </div>
                                    <script language="javascript">print_state("sts");</script>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold text-muted">District</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0">
                                                <i class="fas fa-city text-success"></i>
                                            </span>
                                        </div>
                                        <select id="state" name="district" class="form-control border-left-0" required>
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="font-weight-bold text-muted">Season</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0">
                                                <i class="fas fa-sun text-warning"></i>
                                            </span>
                                        </div>
                                        <select name="Season" class="form-control border-left-0" required>
                                            <option value="">Select Season ...</option>
                                            <option value="Kharif">Kharif</option>
                                            <option value="Whole Year">Whole Year</option>
                                            <option value="Autumn">Autumn</option>
                                            <option value="Rabi">Rabi</option>
                                            <option value="Summer">Summer</option>
                                            <option value="Winter">Winter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" name="Crop_Predict" class="btn btn-predict text-white">
                                    PREDICT CROP
                                </button>
                                <div id="loading" class="mt-3" style="display:none;">
                                    <div class="loader"></div>
                                    <p class="text-muted mt-2">Analyzing data...</p>
                                </div>
                            </div>

                        </form>

                        <?php if(isset($_POST['Crop_Predict'])): ?>
                            <div class="result-box">
                                <?php 
                                    // 1. Get Inputs
                                    $state = trim($_POST['stt']);
                                    $district = trim($_POST['district']);
                                    $season = trim($_POST['Season']);

                                    // 2. Prepare Secure Arguments (Fixes the blank output issue)
                                    $safeState = escapeshellarg($state);
                                    $safeDistrict = escapeshellarg($district);
                                    $safeSeason = escapeshellarg($season);

                                    // 3. Define Path
                                    $pythonScriptPath = __DIR__ . "/ML/crop_prediction/ZDecision_Tree_Model_Call.py";

                                    // 4. Execute
                                    $command = "python \"$pythonScriptPath\" $safeState $safeDistrict $safeSeason 2>&1";
                                    $output = shell_exec($command);
                                ?>
                                
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <i class="fas fa-leaf fa-3x text-success"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <h5 class="text-success font-weight-bold">Recommendation Found!</h5>
                                        <p class="mb-1 text-dark">
                                            For <strong><?php echo $district; ?></strong> during <strong><?php echo $season; ?></strong>, the recommended crops are:
                                        </p>
                                        <h4 class="text-dark font-weight-bold mt-2">
                                            <?php echo $output; ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div> </div>
            </div>
        </div>
    </div>

    <?php require("footer.php"); ?>

    <script>
        function showLoader() {
            document.querySelector('.btn-predict').style.display = 'none';
            document.getElementById('loading').style.display = 'block';
        }
    </script>
</body>
</html>
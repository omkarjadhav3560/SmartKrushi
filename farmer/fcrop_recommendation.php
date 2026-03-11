<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

// 1. Session Check
if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// 2. Fetch User Data
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* --- BASE DESIGN & BACKGROUND --- */
        body {
            font-family: 'Poppins', sans-serif;
            /* High Quality Farm Background */
            background-image: url('https://images.unsplash.com/photo-1625246333195-5512a1d3c15d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5); /* Dark overlay for readability */
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* --- GLASSMORPHISM CARD --- */
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            margin-top: 50px;
            overflow: hidden;
        }

        .panel-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .section-title {
            color: #11998e;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            margin-bottom: 20px;
            border-bottom: 2px solid #38ef7d;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* --- INPUT STYLING --- */
        .input-group-text {
            background: #f1f8e9;
            color: #2e7d32;
            border: 1px solid #ced4da;
            border-right: none;
        }
        
        .form-control {
            height: 50px;
            border-left: none;
            font-size: 15px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #2e7d32;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: #2e7d32;
            background: #2e7d32;
            color: white;
        }

        /* --- BUTTONS --- */
        .btn-predict {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            border: none;
            color: white;
            padding: 15px;
            width: 100%;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }

        .btn-predict:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.6);
            color: white;
        }

        /* --- RESULT BOX --- */
        .result-box {
            margin-top: 30px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            text-align: center;
            border-left: 6px solid #11998e;
            animation: slideUp 0.6s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .result-value {
            font-size: 2.5rem;
            font-weight: 800;
            background: -webkit-linear-gradient(#11998e, #38ef7d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: capitalize;
            margin: 10px 0;
        }

        /* --- LOADER --- */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #11998e;
            border-radius: 50%;
            width: 40px; height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    </style>
</head>

<body>
<div class="overlay">
    
    <?php include ('fnav.php'); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                
                <div class="glass-panel">
                    
                    <div class="panel-header">
                        <h2 class="font-weight-bold m-0"><i class="fas fa-leaf mr-2"></i> Smart Crop Recommendation</h2>
                        <p class="m-0 mt-2 opacity-8">AI-Powered Soil & Climate Analysis</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form role="form" action="#" method="post" onsubmit="showLoader()"> 
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="section-title">Soil Analysis</h5>
                                    
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Nitrogen (N)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flask"></i></span></div>
                                            <input type="number" name="n" class="form-control" placeholder="Ratio (e.g. 90)" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Phosphorus (P)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flask"></i></span></div>
                                            <input type="number" name="p" class="form-control" placeholder="Ratio (e.g. 42)" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Potassium (K)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flask"></i></span></div>
                                            <input type="number" name="k" class="form-control" placeholder="Ratio (e.g. 43)" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Soil pH Value</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-vial"></i></span></div>
                                            <input type="number" step="0.01" name="ph" class="form-control" placeholder="e.g. 6.5" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h5 class="section-title">Environmental Factors</h5>
                                    
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Temperature (°C)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-thermometer-half"></i></span></div>
                                            <input type="number" step="0.01" name="t" class="form-control" placeholder="e.g. 21.5" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Humidity (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tint"></i></span></div>
                                            <input type="number" step="0.01" name="h" class="form-control" placeholder="e.g. 80" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Rainfall (mm)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-cloud-rain"></i></span></div>
                                            <input type="number" step="0.01" name="r" class="form-control" placeholder="e.g. 200" required>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-light border mt-4 p-2">
                                        <small><i class="fas fa-info-circle text-info"></i> Enter accurate values from your Soil Health Card.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6 mx-auto">
                                    <button type="submit" name="Crop_Recommend" class="btn btn-predict" id="btnSubmit">
                                        RECOMMEND CROP
                                    </button>
                                    <div id="loader" class="loader"></div>
                                </div>
                            </div>

                        </form>

                        <?php if(isset($_POST['Crop_Recommend'])): ?>
                            <div class="result-box">
                                <?php 
                                    // 1. Capture Inputs
                                    $n = trim($_POST['n']);
                                    $p = trim($_POST['p']);
                                    $k = trim($_POST['k']);
                                    $t = trim($_POST['t']);
                                    $h = trim($_POST['h']);
                                    $ph = trim($_POST['ph']);
                                    $r = trim($_POST['r']);

                                    // 2. Security: Use escapeshellarg to prevent JSON/Quote errors
                                    $args = escapeshellarg($n) . " " . 
                                            escapeshellarg($p) . " " . 
                                            escapeshellarg($k) . " " . 
                                            escapeshellarg($t) . " " . 
                                            escapeshellarg($h) . " " . 
                                            escapeshellarg($ph) . " " . 
                                            escapeshellarg($r);

                                    // 3. Configure Python Path (Dynamic)
                                    // Finds the script inside: current_folder/ML/crop_recommendation/
                                    $scriptPath = __DIR__ . "/ML/crop_recommendation/recommend.py";
                                    $pythonExec = "python"; // Try 'python' default
                                    
                                    // 4. Run Prediction
                                    $command = "$pythonExec \"$scriptPath\" $args 2>&1";
                                    $output = shell_exec($command);
                                ?>

                                <h6 class="text-uppercase text-muted font-weight-bold">Based on your farm data, the best crop is:</h6>
                                <div class="result-value">
                                    <?php echo $output; ?>
                                </div>
                                <p class="text-dark small">Calculated using Random Forest Algorithm</p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div> </div>
        </div>
    </div>
</div>

<?php require("footer.php");?>

<script>
    function showLoader() {
        document.getElementById('btnSubmit').style.display = 'none';
        document.getElementById('loader').style.display = 'block';
    }
</script>

</body>
</html>
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
        /* --- BACKGROUND & BASE --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1585314062340-f1a5a7c9328d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* CHANGED: From Black to Green Gradient */
        .overlay {
            background: linear-gradient(to bottom, rgba(20, 80, 20, 0.6), rgba(40, 167, 69, 0.4));
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* --- GLASS PANEL --- */
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            margin-top: 50px;
            overflow: hidden;
        }

        .panel-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .section-title {
            color: #28a745;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border-bottom: 2px solid #20c997;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* --- FORM STYLES --- */
        .input-group-text {
            background: #e8f5e9;
            color: #28a745;
            border: 1px solid #ced4da;
            border-right: none;
        }
        
        .form-control {
            height: 50px;
            border-left: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: #28a745;
            background: #28a745;
            color: white;
        }

        /* --- BUTTONS --- */
        .btn-predict {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 15px;
            width: 100%;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        .btn-predict:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.6);
            color: white;
        }

        /* --- RESULT BOX --- */
        .result-box {
            margin-top: 30px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            text-align: center;
            border-left: 6px solid #28a745;
            animation: slideUp 0.6s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .result-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #28a745;
            text-transform: capitalize;
            margin: 10px 0;
        }

        /* --- LOADER --- */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
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
                        <h2 class="font-weight-bold m-0"><i class="fas fa-seedling mr-2"></i> Smart Fertilizer Recommender</h2>
                        <p class="m-0 mt-2 opacity-8">Optimize your soil health with AI-driven advice</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form role="form" action="#" method="post" onsubmit="showLoader()"> 
                            
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <h5 class="section-title">Soil Composition</h5>
                                    
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Nitrogen (N)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flask"></i></span></div>
                                            <input type="number" name="n" class="form-control" placeholder="Ratio (e.g. 37)" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Phosphorus (P)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flask"></i></span></div>
                                            <input type="number" name="p" class="form-control" placeholder="Ratio (e.g. 0)" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Potassium (K)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flask"></i></span></div>
                                            <input type="number" name="k" class="form-control" placeholder="Ratio (e.g. 0)" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h5 class="section-title">Environment</h5>
                                    
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Temperature (°C)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-thermometer-half"></i></span></div>
                                            <input type="number" step="0.01" name="t" class="form-control" placeholder="e.g. 26" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Humidity (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tint"></i></span></div>
                                            <input type="number" step="0.01" name="h" class="form-control" placeholder="e.g. 52" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Soil Moisture</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-water"></i></span></div>
                                            <input type="number" step="0.01" name="soilMoisture" class="form-control" placeholder="e.g. 38" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h5 class="section-title">Farm Details</h5>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Soil Type</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-layer-group"></i></span></div>
                                            <select name="soil" class="form-control" required>
                                                <option value="">Select Soil Type</option>
                                                <option value="Sandy">Sandy</option>
                                                <option value="Loamy">Loamy</option>
                                                <option value="Black">Black</option>
                                                <option value="Red">Red</option>
                                                <option value="Clayey">Clayey</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Target Crop</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-seedling"></i></span></div>
                                            <select name="crop" class="form-control" required>
                                                <option value="">Select Crop</option>
                                                <option value="Maize">Maize</option>
                                                <option value="Sugarcane">Sugarcane</option>
                                                <option value="Cotton">Cotton</option>
                                                <option value="Tobacco">Tobacco</option>
                                                <option value="Paddy">Paddy</option>
                                                <option value="Barley">Barley</option>
                                                <option value="Wheat">Wheat</option>
                                                <option value="Millets">Millets</option>
                                                <option value="Oil seeds">Oil seeds</option>
                                                <option value="Pulses">Pulses</option>
                                                <option value="Ground Nuts">Ground Nuts</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6 mx-auto">
                                    <button type="submit" name="Fert_Recommend" class="btn btn-predict" id="btnSubmit">
                                        GET RECOMMENDATION
                                    </button>
                                    <div id="loader" class="loader"></div>
                                </div>
                            </div>

                        </form>

                        <?php if(isset($_POST['Fert_Recommend'])): ?>
                            <div class="result-box">
                                <?php 
                                    // 1. Capture Inputs
                                    $n = trim($_POST['n']);
                                    $p = trim($_POST['p']);
                                    $k = trim($_POST['k']);
                                    $t = trim($_POST['t']);
                                    $h = trim($_POST['h']);
                                    $sm = trim($_POST['soilMoisture']);
                                    $soil = trim($_POST['soil']);
                                    $crop = trim($_POST['crop']);

                                    // 2. Security: Use escapeshellarg (CRITICAL for strings like "Ground Nuts")
                                    $args = escapeshellarg($n) . " " . 
                                            escapeshellarg($p) . " " . 
                                            escapeshellarg($k) . " " . 
                                            escapeshellarg($t) . " " . 
                                            escapeshellarg($h) . " " . 
                                            escapeshellarg($sm) . " " . 
                                            escapeshellarg($soil) . " " . 
                                            escapeshellarg($crop);

                                    // 3. Configure Python Path
                                    $scriptPath = __DIR__ . "/ML/fertilizer_recommendation/fertilizer_recommendation.py";
                                    $pythonExec = "python"; // Try 'python' default
                                    
                                    // 4. Run Prediction
                                    $command = "$pythonExec \"$scriptPath\" $args 2>&1";
                                    $output = shell_exec($command);
                                ?>

                                <h6 class="text-uppercase text-muted font-weight-bold">Recommended Fertilizer Application</h6>
                                <div class="result-value">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <?php echo $output; ?>
                                </div>
                                <p class="text-secondary small">Always consult a local agricultural expert before application.</p>
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
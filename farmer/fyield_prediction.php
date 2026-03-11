<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// Fetch user data
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
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1625246333195-5512a1d3c15d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5); /* Darker overlay for readability */
            min-height: 100vh;
            padding-bottom: 50px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 40px;
            margin-top: 50px;
        }

        .section-title {
            color: #2d5a27;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 3px solid #4caf50;
            display: inline-block;
            padding-bottom: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding-left: 15px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-predict {
            background: linear-gradient(135deg, #28a745, #218838);
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            color: white;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            transition: transform 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .btn-predict:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.6);
        }

        .result-box {
            background: #e8f5e9;
            border-left: 5px solid #2e7d32;
            padding: 25px;
            border-radius: 8px;
            margin-top: 30px;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Loading Spinner */
        .spinner-wrapper {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        .fa-spin {
            color: #28a745;
        }
    </style>
</head>

<body>
<div class="overlay">
    
    <?php include ('fnav.php'); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                
                <div class="glass-card">
                    <div class="text-center">
                        <h2 class="section-title">Smart Yield Estimation</h2>
                        <p class="text-muted mb-4">Select your farm details below to estimate expected production.</p>
                    </div>

                    <form role="form" action="#" method="post" id="yieldForm" onsubmit="showLoading()">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-map text-success"></i></span>
                                    </div>
                                    <select name="state" class="form-control" required readonly>
                                        <option value="Karnataka" selected>Karnataka</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">District</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-city text-success"></i></span>
                                    </div>
                                    <select id="district" name="district" class="form-control" required>
                                        <option value="">Select District</option>
                                        <option value="BAGALKOT">Bagalkot</option>
                                        <option value="BANGALORE_RURAL">Bangalore Rural</option>
                                        <option value="BELGAUM">Belgaum</option>
                                        <option value="BELLARY">Bellary</option>
                                        <option value="BENGALURU_URBAN">Bengaluru Urban</option>
                                        <option value="BIDAR">Bidar</option>
                                        <option value="BIJAPUR">Bijapur</option>
                                        <option value="CHIKMAGALUR">Chikmagalur</option>
                                        <option value="CHITRADURGA">Chitradurga</option>
                                        <option value="DAKSHIN_KANNAD">Dakshin Kannad</option>
                                        <option value="DAVANGERE">Davangere</option>
                                        <option value="DHARWAD">Dharwad</option>
                                        <option value="GADAG">Gadag</option>
                                        <option value="GULBARGA">Gulbarga</option>
                                        <option value="HASSAN">Hassan</option>
                                        <option value="HAVERI">Haveri</option>
                                        <option value="KODAGU">Kodagu</option>
                                        <option value="KOLAR">Kolar</option>
                                        <option value="KOPPAL">Koppal</option>
                                        <option value="MANDYA">Mandya</option>
                                        <option value="MYSORE">Mysore</option>
                                        <option value="RAICHUR">Raichur</option>
                                        <option value="RAMANAGARA">Ramanagara</option>
                                        <option value="SHIMOGA">Shimoga</option>
                                        <option value="TUMKUR">Tumkur</option>
                                        <option value="UDUPI">Udupi</option>
                                        <option value="UTTAR_KANNAD">Uttar Kannad</option>
                                        <option value="YADGIR">Yadgir</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Season</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-cloud-sun text-warning"></i></span>
                                    </div>
                                    <select id="season" name="Season" class="form-control" required>
                                        <option value="">Select Season...</option>
                                        <option value="Kharif">Kharif</option>
                                        <option value="Rabi">Rabi</option>
                                        <option value="Summer">Summer</option>
                                        <option value="Whole Year">Whole Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Crop</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-seedling text-success"></i></span>
                                    </div>
                                    <select id="crop" name="crops" class="form-control" required>
                                        <option value="">Select District & Season first</option>
                                    </select>
                                </div>
                                <small class="text-muted">Auto-populated based on region</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Farm Area (Hectares)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-ruler-combined text-primary"></i></span>
                                    </div>
                                    <input type="number" step="0.01" name="area" placeholder="Ex: 2.5" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="Yield_Predict" class="btn btn-predict">
                                Predict Yield
                            </button>
                        </div>

                        <div id="loadingSpinner" class="spinner-wrapper">
                            <i class="fas fa-circle-notch fa-spin fa-3x"></i>
                            <p class="mt-2 font-weight-bold text-success">Analyzing Data...</p>
                        </div>

                    </form>

                    <?php if(isset($_POST['Yield_Predict'])): ?>
                    <div class="result-box">
                        <h4 class="text-dark font-weight-bold">
                            <i class="fas fa-chart-line text-success mr-2"></i> Prediction Result
                        </h4>
                        <hr>
                        <?php 
                            // 1. Get Inputs
                            $state = trim($_POST['state']);
                            $district = trim($_POST['district']);
                            $season = trim($_POST['Season']);
                            $crops = trim($_POST['crops']);
                            $area = trim($_POST['area']);

                            // 2. Prepare Safe Arguments (Fixing the blank output issue)
                            // We use escapeshellarg instead of json_encode to prevent extra quotes issues in Python
                            $safeState = escapeshellarg($state);
                            $safeDistrict = escapeshellarg($district);
                            $safeSeason = escapeshellarg($season);
                            $safeCrops = escapeshellarg($crops);
                            $safeArea = escapeshellarg($area);

                            // 3. Define Path
                            $pythonScriptPath = __DIR__ . "/ML/yield_prediction/yield_prediction.py";

                            // 4. Run Command
                            $command = "python \"$pythonScriptPath\" $safeState $safeDistrict $safeSeason $safeCrops $safeArea 2>&1";
                            $output = shell_exec($command);
                        ?>
                        
                        <p class="mb-2" style="font-size: 1.1rem;">
                            For <strong><?php echo $area; ?> Hectares</strong> of <strong><?php echo $crops; ?></strong> in <?php echo $district; ?>:
                        </p>
                        <h2 class="text-success font-weight-bold">
                            <?php echo $output; ?> <small class="text-dark" style="font-size: 0.6em;">Quintals (Approx)</small>
                        </h2>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require("footer.php");?>

<script>
    function showLoading() {
        document.querySelector('.btn-predict').style.display = 'none';
        document.getElementById('loadingSpinner').style.display = 'block';
    }

    // SAMPLE DATA STRUCTURE - YOU MUST FILL THIS WITH YOUR FULL DATA
    // I have added data for 'BAGALKOT' as an example. 
    const cropOptions = {
        "BAGALKOT": {
            "Kharif": ["Maize", "Jowar", "Bajra", "Green Gram"],
            "Rabi": ["Wheat", "Jowar", "Bengal Gram"],
            "Summer": ["Groundnut", "Sunflower"],
            "Whole Year": ["Sugarcane", "Coconut"]
        },
        "BANGALORE_RURAL": {
            "Kharif": ["Ragi", "Maize"],
            "Rabi": ["Horse Gram"],
            "Summer": ["Rice"],
            "Whole Year": ["Arecanut"]
        },
        // Add other districts here...
        "BELGAUM": { "Kharif": ["Maize", "Rice"], "Rabi": ["Wheat"], "Summer": ["Groundnut"], "Whole Year": ["Sugarcane"] }
    };

    document.getElementById("season").addEventListener("change", function() {  
        const districtDropdown = document.getElementById('district');
        const seasonDropdown = document.getElementById('season');
        const cropDropdown = document.getElementById('crop');

        const selectedDistrict = districtDropdown.value;
        const selectedSeason = seasonDropdown.value;

        // Reset Crop Dropdown
        cropDropdown.innerHTML = '<option value="">Select crop</option>';
        
        // Validation: Ensure both are selected
        if (selectedDistrict && selectedSeason) {
            // Check if data exists for this combination
            if (cropOptions[selectedDistrict] && cropOptions[selectedDistrict][selectedSeason]) {
                const options = cropOptions[selectedDistrict][selectedSeason];
                
                options.forEach(function(crop) {
                    const optionElement = document.createElement('option');
                    optionElement.value = crop;
                    optionElement.text = crop;
                    cropDropdown.appendChild(optionElement);
                });
            } else {
                const optionElement = document.createElement('option');
                optionElement.text = "No data available for this selection";
                cropDropdown.appendChild(optionElement);
            }
        }
    }); 
</script>

</body>
</html>
<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
} 

// Get Farmer District
$query = (filter_var($user_check, FILTER_VALIDATE_EMAIL)) 
    ? "SELECT F_District, farmer_name FROM farmerlogin WHERE email='$user_check'"
    : "SELECT F_District, farmer_name FROM farmerlogin WHERE phone_no='$user_check'";

$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);
$District_name_farmer = $userData['F_District'] ?? 'Nanded';
$farmer_name = $userData['farmer_name'] ?? 'Farmer';

// Get Weather ID from JSON
$weather_data = json_decode(file_get_contents('static/citylist.json'));
$cityId = "1253952"; // Default (Udupi)

foreach ($weather_data as $city) {
    if (trim(strtolower($city->name)) == trim(strtolower($District_name_farmer))) {
        $cityId = strval($city->id);
        break;
    }
}

// API Call
$apiKey = "870887df4d2b01335921fe396c69a360"; 
$apiUrl = "https://api.openweathermap.org/data/2.5/forecast?id=$cityId&lang=en&units=metric&APPID=$apiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response);
$forecast = $data->list;
$current = $forecast[0]; // First entry as current weather
?>

<!DOCTYPE html>
<html>
<?php include ('fheader.php'); ?>
<style>
    .weather-card {
        background: linear-gradient(150deg, #2dce89 0, #2dcecc 100%);
        border: none;
        border-radius: 1rem;
    }
    .temp-display { font-size: 3rem; font-weight: 800; }
    .weather-icon-lg { width: 100px; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2)); }
    .table-container { background: white; border-radius: 1rem; padding: 20px; box-shadow: 0 15px 35px rgba(50,50,93,.1), 0 5px 15px rgba(0,0,0,.07); }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #2dce89 !important; border: none; color: white !important; }
</style>

<body class="bg-white">
<?php include ('fnav.php'); ?>

<section class="section section-shaped section-lg">
    <div class="shape shape-style-1 shape-primary">
        <span></span><span></span><span></span><span></span>
    </div>

    <div class="container mt--8">
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="card weather-card text-white shadow-lg">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="text-white text-uppercase ls-1">Current Status: <?php echo $District_name_farmer; ?></h6>
                                <div class="temp-display"><?php echo round($current->main->temp); ?>°C</div>
                                <p class="display-4 text-capitalize"><?php echo $current->weather[0]->description; ?></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <img src="http://openweathermap.org/img/wn/<?php echo $current->weather[0]->icon; ?>@4x.png" class="weather-icon-lg">
                                <div class="mt-3">
                                    <span><i class="fas fa-droplet mr-2"></i> Humidity: <?php echo $current->main->humidity; ?>%</span>
                                    <span class="ml-4"><i class="fas fa-wind mr-2"></i> Wind: <?php echo $current->wind->speed; ?> km/h</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-container">
                    <h3 class="mb-4 text-primary"><i class="fas fa-calendar-alt mr-2"></i> 5-Day / 3-Hour Forecast</h3>
                    <div class="table-responsive">
                        <table class="table table-flush" id="weatherTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Temp (Max/Min)</th>
                                    <th>Condition</th>
                                    <th>Humidity</th>
                                    <th>Wind</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($forecast as $f): 
                                    $date = date("D, d M", strtotime($f->dt_txt));
                                    $time = date("h:i A", strtotime($f->dt_txt));
                                ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $date; ?></td>
                                    <td><?php echo $time; ?></td>
                                    <td>
                                        <span class="text-danger"><?php echo $f->main->temp_max; ?>°</span> 
                                        / <span class="text-info"><?php echo $f->main->temp_min; ?>°</span>
                                    </td>
                                    <td class="text-capitalize">
                                        <img src="http://openweathermap.org/img/wn/<?php echo $f->weather[0]->icon; ?>.png" width="30">
                                        <?php echo $f->weather[0]->description; ?>
                                    </td>
                                    <td><?php echo $f->main->humidity; ?>%</td>
                                    <td><?php echo $f->wind->speed; ?> km/h</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require("footer.php");?>

<script>
$(document).ready(function() {
    $('#weatherTable').DataTable({
        "pageLength": 8,
        "ordering": false,
        "language": {
            "paginate": {
                "previous": "<i class='fas fa-angle-left'>",
                "next": "<i class='fas fa-angle-right'>"
            }
        }
    });
});
</script>
</body>
</html>
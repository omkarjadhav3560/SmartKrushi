<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
} 

$apiKey = "e13c1810209a4e6ca7997d39b797152c";
$query = urlencode('kisan OR "indian agriculture" OR "farming news" OR "crop prices"');
$url = "https://newsapi.org/v2/everything?q=$query&sortBy=publishedAt&language=en&apiKey=$apiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "SmartKrushiPortal/1.0");
$response = curl_exec($ch);
curl_close($ch);

$newsdata = json_decode($response);
?>

<!DOCTYPE html>
<html lang="en">
<?php include ('fheader.php'); ?>
<style>
    body {
        /* New Agriculture Background with dark overlay */
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2000');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }

    .news-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease;
        /* Glassmorphism Effect */
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        height: 100%;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
    }

    .news-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 1);
    }

    .news-img {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    /* Fixed height for content to keep cards equal size */
    .news-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #32325d;
        height: 3em;
        overflow: hidden;
    }

    .news-desc {
        font-size: 0.9rem;
        color: #525f7f;
        height: 4.5em;
        overflow: hidden;
    }
</style>

<body>
<?php include ('fnav.php'); ?>

<section class="section section-lg">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-white display-3 font-weight-bold">Kisan News Update</h1>
                <p class="text-white opacity-8 lead">Real-time agricultural insights and market trends for modern farming.</p>
            </div>
        </div>

        <div class="row">
            <?php 
            if($newsdata && $newsdata->status == "ok"):
                $count = 0;
                foreach($newsdata->articles as $news): 
                    if(empty($news->urlToImage) || $count >= 12) continue;
                    $count++;
            ?>
            <div class="col-12 col-md-6 col-lg-4 mb-5"> 
                <div class="card news-card">
                    <img src="<?php echo $news->urlToImage ?>" class="news-img" alt="News Image">
                    <div class="card-body d-flex flex-column">
                        <small class="text-success font-weight-bold mb-2">
                            <i class="fa fa-calendar-alt mr-1"></i> <?php echo date("d M Y", strtotime($news->publishedAt)); ?>
                        </small>
                        <h5 class="news-title"><?php echo $news->title; ?></h5>
                        <p class="news-desc"><?php echo $news->description; ?></p>
                        <div class="mt-auto pt-3">
                            <a href="<?php echo $news->url ?>" target="_blank" class="btn btn-primary btn-block shadow-none">Read Full Story</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach; 
            else:
                echo "<div class='col-12 text-center text-white'><h3>No news found. Check your connection.</h3></div>";
            endif;
            ?>
        </div>
    </div>
</section>

<?php require("footer.php");?>
</body>
</html>
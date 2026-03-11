<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "agriculture_portal"; // ❌ REMOVE ':' and spaces

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>

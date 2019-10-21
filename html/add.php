<?php
session_start();

require_once "config.php";

$show = "null";
$platform = "none";
$when = "null";

if(isset($_POST['show'])){
   $show = trim($_POST['show']);
}
if(isset($_POST['platform']) && $_POST['platform'] != "Platform"){
   $platform = trim($_POST['platform']);
}
if(isset($_POST['when'])){
   $when = trim($_POST['when']);
}

echo $show." on ".$platform." ".$when;

$sql = "INSERT INTO requests (username, media, platform, whenToWatch, location, college, coord_lat, coord_long) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ssssssdd", $userParam, $showParam, $platformParam, $whenParam, $locationParam, $collegeParam, $latParam, $longParam);

    $userParam = $_SESSION["username"];
    $showParam = $show;
    $platformParam = $platform;
    $whenParam = $when;
    $locationParam = $_SESSION["location"];
    $collegeParam = $_SESSION["college"];
    $latParam = $_SESSION["coord_lat"];
    $longParam = $_SESSION["coord_long"];

    if($stmt->execute()){
        header("location: index");
    } else{
        echo("Statement failed: ". $stmt->error . "<br>");

        echo "Something went wrong. Please try again later.";
    }
}
$stmt->close();
$mysqli->close();
?>

<?php
session_start();

require_once "config.php";

$show = "the office";
$platform = "netflix";
$when = "tonight";

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

$sql = "INSERT INTO requests (username, media, platform, whenToWatch) VALUES (?, ?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ssss", $userParam, $showParam, $platformParam, $whenParam);

    $userParam = $_SESSION["username"];
    $showParam = $show;
    $platformParam = $platform;
    $whenParam = $when;

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

<?php
session_start();

require_once "config.php";

$id = -1;
$name = "null";
$desc = "null";
$img = "null";
$when = "null";
if(isset($_POST['id'])){
   $id = trim($_POST['id']);
}

if(isset($_POST['name'])){
   $name = trim($_POST['name']);
}

if(isset($_POST['desc'])){
   $desc = trim($_POST['desc']);
}

if(isset($_POST['img'])){
   $img = trim($_POST['img']);
}

$sql = "INSERT INTO requests (username, media, whenToWatch, location, college, coord_lat, coord_long, mediaId, img, summary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("sssssddiss", $userParam, $showParam, $whenParam, $locationParam, $collegeParam, $latParam, $longParam, $mIdParam, $imgParam, $sumParam);

    $userParam = $_SESSION["username"];
    $showParam = $name;
    $whenParam = $when;
    $locationParam = $_SESSION["location"];
    $collegeParam = $_SESSION["college"];
    $latParam = $_SESSION["coord_lat"];
    $longParam = $_SESSION["coord_long"];
    $mIdParam = $id;
    $sumParam = $desc;
    $imgParam = $img;


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

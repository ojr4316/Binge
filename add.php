<?php
session_start();

require_once "config.php";

$id = -1;
$name = "null";
$desc = "null";
$img = "null";

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

$sql = "INSERT INTO requests (username, media, location, college, coord_lat, coord_long, mediaId, img, summary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ssssddiss", $userParam, $showParam, $locationParam, $collegeParam, $latParam, $longParam, $mIdParam, $imgParam, $sumParam);

    $userParam = $_SESSION["username"];
    $showParam = $name;
    if (isset($_SESSION["location"])) {
      $locationParam = $_SESSION["location"];
    } else {
      $locationParam = "none";
    }
    if (isset($_SESSION["college"])) {
      $collegeParam = $_SESSION["college"];
    } else {
      $collegeParam = "none";
    }
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

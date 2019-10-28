<?php
session_start();
require_once "config.php";

$lat = 0;
$long = 0;
preg_match('#\((.*?)\)#', $_POST["location"], $match);
$sql = "SELECT * FROM US_CITIES WHERE ID = ".$match[1];
$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
while($row=mysqli_fetch_array($result)){
  $lat = $row['LATITUDE'];
  $long = $row['LONGITUDE'];
}

// Setting readable location
$sql = "UPDATE users SET coord_lat = ?, coord_long = ?, location = ? WHERE username = ?";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ddss", $param_lat, $param_long, $param_location, $param_username);
    $param_lat = $lat;
    $param_long = $long;
    $param_location = substr($_POST["location"], 0, strpos($_POST["location"], "("));
    $param_username = $_SESSION["username"];
    if($stmt->execute()){
      $_SESSION["location"] =  $_POST["location"];
      $_SESSION["coord_lat"] = $lat;
      $_SESSION["coord_long"] = $long;
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
$stmt->close();
}

$sql = "UPDATE requests SET coord_lat = ?, coord_long = ?, location = ? WHERE username = ?";
if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ddss", $param_lat, $param_long, $param_location, $param_username);
    $param_lat = $lat;
    $param_long = $long;
    $param_location = substr($_POST["location"], 0, strpos($_POST["location"], "("));
    $param_username = $_SESSION["username"];
    if($stmt->execute()){
      $_SESSION["location"] =  $_POST["location"];
      $_SESSION["coord_lat"] = $lat;
      $_SESSION["coord_long"] = $long;
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
$stmt->close();
}

$mysqli->close();
?>

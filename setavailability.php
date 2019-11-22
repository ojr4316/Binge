<?php
session_start();
require_once "config.php";

$sql = "UPDATE users SET availability = ? WHERE username = ?";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $param_availability, $param_username);
    $param_availability = json_encode($_POST["days"]);
    $param_username = $_SESSION["username"];
    if($stmt->execute()){
      $_SESSION["availability"] =  $_POST["days"];
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
$stmt->close();

$mysqli->close();
?>

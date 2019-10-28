<?php
session_start();
require_once "config.php";

$sql = "UPDATE users SET college = ? WHERE username = ?";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $param_college, $param_username);
    $param_college = $_POST["college"];
    $param_username = $_SESSION["username"];
    if($stmt->execute()){
      $_SESSION["college"] =  $_POST["college"];
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
$stmt->close();

$sql = "UPDATE requests SET college = ? WHERE username = ?";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $param_college, $param_username);
    $param_college = $_POST["college"];
    $param_username = $_SESSION["username"];
    if($stmt->execute()){
      $_SESSION["college"] =  $_POST["college"];
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
$stmt->close();

$mysqli->close();
?>

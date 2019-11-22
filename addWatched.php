<?php
session_start();
require_once "config.php";

$exists = false;

$sql = "SELECT id FROM watched WHERE username = ? AND media_id = ?";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $param_username, $param_media_id);
    $param_username = $_SESSION["username"];
    $param_media_id = trim($_POST["id"]);

    if($stmt->execute()){
        $stmt->store_result();
        if($stmt->num_rows >= 1){
          $exists = true;
        }
    }
    $stmt->close();
}

if (!$exists) {
$sql = "INSERT INTO watched (username, media_id, title, img) VALUES (?, ?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("siss", $username, $mId, $title, $image);

    $username = $_SESSION["username"];
    $mId = trim($_POST["id"]);
    $title = trim($_POST["name"]);
    $image = trim($_POST["img"]);

    if($stmt->execute()){
    } else {
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
    $stmt->close();
}
}
$mysqli->close();
?>

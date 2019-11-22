<?php
session_start();

require_once "config.php";

$sql = "DELETE FROM `watched` WHERE `media_id`=?";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("i", $idParam);
    $idParam = $_GET['id'];
    if($stmt->execute()){
    } else{
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
    $stmt->close();
}
$mysqli->close();
?>

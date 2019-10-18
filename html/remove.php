<?php
session_start();

require_once "config.php";

$sql = "DELETE FROM `requests` WHERE `id`=?";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("i", $idParam);
    $idParam = $_GET['id'];
    if($stmt->execute()){
        $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
        header("location: ".$referer);
    } else{
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
}
$stmt->close();
$mysqli->close();
?>

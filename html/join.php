<?php
session_start();

require_once "config.php";

$sql = "INSERT INTO joinRequests (requestId, joinUsername, showTo) VALUES (?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("iss", $requestIdParam, $joinUsernameParam, $showToParam);

    $requestIdParam = $_GET['id'];
    $joinUsernameParam = $_SESSION['username'];
    $showToParam = $_GET['showTo'];

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

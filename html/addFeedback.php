<?php
session_start();

require_once "config.php";

$feedback = "none";

if(isset($_POST['feedback'])){
   $feedback = trim($_POST['feedback']);
}

$sql = "INSERT INTO feedback (username, feedback) VALUES (?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $userParam, $feedbackParam);

    $userParam = $_SESSION["username"];
    $feedbackParam = $feedback;

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

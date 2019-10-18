<?php
session_start();

require_once "config.php";

$sql = "INSERT INTO chat (chatId, sender, message) VALUES (?, ?, ?)";

echo "running";
echo "username: ".$_SESSION['username'];

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("iss", $chatIdParam, $senderParam, $messageParam);

    $chatIdParam = $_POST["chatId"];
    $senderParam = $_SESSION['username'];
    $messageParam = trim($_POST['text']);

    if($stmt->execute()){
    }else{
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
}

$stmt->close();

$mysqli->close();
?>

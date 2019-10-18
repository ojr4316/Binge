<?php
session_start();

require_once "config.php";

// Accept Request
$email = "";
$sql = "SELECT * FROM `users` WHERE username='".$_GET['user']."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $email = $row["email"];
    }
}

// Check to see if users have a chat
$hasChat = false;
$chat_id = -1;

$sql = "SELECT id FROM chats WHERE userOne = '".$_SESSION['username']."' AND userTwo = '".$_GET["user"]."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $chat_id = $row['id'];
      $hasChat = true;
    }
}

if (!$hasChat) {
  $sql = "SELECT id FROM chats WHERE userOne = '".$_GET["user"]."' AND userTwo = '".$_SESSION['username']."'";
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $chat_id = $row['id'];
        $hasChat = true;
      }
  }
}


// Start Chat if don't have one
if (!$hasChat) {
$sql = "INSERT INTO chats (userOne, userTwo) VALUES (?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $userOneParam, $userTwoParam);

    $userOneParam = $_SESSION["username"];
    $userTwoParam = $_GET['user'];

    if($stmt->execute()){
    }else{
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
}
$stmt->close();

$sql = "SELECT id FROM chats WHERE userOne = '".$_SESSION['username']."' AND userTwo = '".$_GET["user"]."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $chat_id = $row['id'];
    }
}

$sql = "SELECT id FROM chats WHERE userOne = '".$_GET["user"]."' AND userTwo = '".$_SESSION['username']."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $chat_id = $row['id'];
    }
}
}

$sql = "INSERT INTO chat (chatId, sender, message) VALUES (?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("iss", $chatIdParam, $senderParam, $messageParam);

    $chatIdParam = $chat_id;
    $senderParam = "SERVER";
    $messageParam = PHP_EOL."Lets watch ".$_GET['media'].PHP_EOL;

    if($stmt->execute()){
    }else{
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
}
$stmt->close();

header("location: deleteRequest.php?id=".$_GET['id']);

$mysqli->close();
?>

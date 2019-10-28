<?php
session_start();

require_once "config.php";

$sql  = 'SELECT * FROM ( SELECT sender, message, created FROM chat WHERE chatId="'.$_GET["chatId"].'" ORDER BY created DESC LIMIT 100) sub ORDER BY created ASC';

$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if ($row['sender'] == "SERVER") {
        echo "<b class='m-0'>".$row['message']."</b>";
      } else {
        echo "<p class='m-0'>".$row['sender'].": ".$row['message']."</p>";
      }
    }
}


$mysqli->close();
?>

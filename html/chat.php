<?php
$page = "chats";
include 'pageSetup.php';

$toPrint = "<script> window.onload = function() {";
$sql = "SELECT id, userTwo FROM chats WHERE userOne = '".$_SESSION['username']."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $toPrint .= 'addChatOption("'. $row['id'] .'", "'. $row['userTwo'] .'");';
    }
}

$sql = "SELECT id, userOne FROM chats WHERE userTwo = '".$_SESSION['username']."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $toPrint .= 'addChatOption("'. $row['id'] .'", "'. $row['userOne'] .'");';
  }
}

$toPrint .= " }; </script>";
echo $toPrint;

$mysqli->close();
?>

  <div id="chatSelect"></div>

  <div id="chatbox" class="mx-auto">
    <form class="chatForm" id="chat">
      <textarea readonly id="chatArea" class="form-control"></textarea>
      <input id="textToAdd" style="" type="text"></input>
      <button id="sendButton" class="binge-red-bg chat-button" type="submit">Send</button>
    </form>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="index.js"></script>
</html>

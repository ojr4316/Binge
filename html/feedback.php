<?php
include("pageSetup.php");

// Get Joined Requests
$joined = array();
$sql  = 'SELECT * FROM `joinRequests` WHERE `joinUsername`="'.$_SESSION['username'].'"';
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($joined, $row['requestId']);
    }
}

// Get User's Request
$sql = "SELECT * FROM `requests` WHERE `college` = '".$_SESSION["college"]."' LIMIT 100";
$result = $mysqli->query($sql);
$toPrint = "<script> window.onload = function() {";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['username'] == $_SESSION['username']) {
          $toPrint .= 'addYourCard("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        } else {
        if (in_array($row['id'], $joined)) {
          $toPrint .= 'addCardJoined("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        } else {
          $toPrint .= 'addCard("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        }
      }
    }
    $toPrint .= "  if ($('#cards').children().length > 3) { $('.col').addClass('col-sm-4');} }; </script>";
    echo $toPrint;
}

$mysqli->close();
?>

<div class="container">
<form class="mt-5" id="watchRequest" method="post" action="addFeedback.php">
  <h3> We'd love to hear from you! </h3>
  <div class="form-group">
    <textarea required class="form-control" id="feedbackInput" name="feedback" rows="5" style="resize: none;"></textarea>
  </div>
  <button type="submit" class="btn btn-primary binge-red-bg ">Submit</button>
</form>
</div>
</body>

</html>

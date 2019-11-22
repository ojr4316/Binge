<?php
$page = "tickets";
include('pageSetup.php');

if ($_SESSION["location"] == "" && $_SESSION["college"] == "") {
  header("location: noset");
}

// Get Join Requests pertaining to self
$joinNames = array();
$requestIds = array();
$joinRequests = array();

$sql = "SELECT * FROM `joinRequests` WHERE `showTo`='".$_SESSION['username']."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($joinNames, $row['joinUsername']);
      array_push($requestIds, $row['requestId']);
      array_push($joinRequests, $row['id']);
    }
}

# Get Request Info for user
$toPrint = "<script> window.onload = function() {";
for($x = 0; $x < count($requestIds); $x++) {
  $sql = "SELECT * FROM `requests` WHERE `id`='".$requestIds[$x]."'";
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $toPrint .= 'addCardRequest("'.$joinNames[$x].'", "'.$row['media'].'", "'.$joinRequests[$x].'", "'.$row['img'].'", "'.$row['summary'].'");';
      }
  }
}
$toPrint .= " if ($('#cards').children().length == 0) { $('.container').append('<div class=".'"p-3 text-center binge-white-box "'."><h4> Requests from other users will show up here </h4></div>')} else { resizeTickets(); } }; </script>";
echo $toPrint;
$mysqli->close();
?>

<div class="container my-5">
  <div id="cards" class="row m-3"></div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>

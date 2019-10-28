<?php
$page = "index";
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
$toPrint = "<script> window.onload = function() {";
$dups = array();
if (isset($_SESSION["location"]) && $_SESSION['location'] != "") {
$sql = "SELECT *, ( 3959 * acos( cos( radians(".$_SESSION['coord_lat'].") ) * cos( radians( `coord_lat` ) ) * cos( radians( `coord_long` ) - radians(".$_SESSION['coord_long'].") ) + sin( radians(".$_SESSION['coord_lat'].") ) * sin( radians( `coord_lat` ) ) ) ) AS distance FROM requests HAVING distance < 25 ORDER BY distance LIMIT 100;";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['username'] == $_SESSION['username']) {
          $toPrint .= 'addYourCard("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
        } else {
        if (in_array($row['id'], $joined)) {
          $toPrint .= 'addCardJoined("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
        } else {
          $toPrint .= 'addCard("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
        }
      }
      array_push($dups, $row['id']);
    }
}
}

if (isset($_SESSION["college"]) && $_SESSION['college'] != "") {
$sql = "SELECT * FROM `requests` WHERE `college` = '".$_SESSION["college"]."' LIMIT 100 ORDER BY `started`";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if (!in_array($row['id'], $dups)) {
        if ($row['username'] == $_SESSION['username']) {
          $toPrint .= 'addYourCard("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
        } else {
        if (in_array($row['id'], $joined)) {
          $toPrint .= 'addCardJoined("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
        } else {
          $toPrint .= 'addCard("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
        }
      }
    }
    }
}
}

$toPrint .= "  if ($('#cards').children().length > 0) { $('#deleteMe').remove(); } resizeTickets(); }; </script>";
echo $toPrint;

$mysqli->close();
?>

<div class="container-fluid">
  <div class="mt-3" id="deleteMe">
  <h4 class=text-center> No Results Found </h4>
  <h5 class=text-center> Try setting your location on your profile </h5>
  </div>
<div id="cards" class="row m-5 p-5"></div>
</div>

<div id="disclaimer">
  <p class="mb-0 text-white p-3" style="background-color: black;"> Binge does not own any rights to any of the movies or shows displayed </p>
</div>

</body>
<script src="index.js"></script>

</html>

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
          $toPrint .= 'addYourCard("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        } else {
        if (in_array($row['id'], $joined)) {
          $toPrint .= 'addCardJoined("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        } else {
          $toPrint .= 'addCard("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        }
      }
      array_push($dups, $row['id']);
    }
} else {

}
}

if (isset($_SESSION["college"]) && $_SESSION['college'] != "") {
$sql = "SELECT * FROM `requests` WHERE `college` = '".$_SESSION["college"]."' LIMIT 100";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if (!in_array($row['id'], $dups)) {
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
    }
} else {

}
}

$toPrint .= "  if ($('#cards').children().length > 0) { $('#deleteMe').remove(); } if ($('#cards').children().length > 3) { $('.col').addClass('col-sm-4');} }; </script>";
echo $toPrint;

$mysqli->close();
?>

<div class="container">
  <div class="mt-3" id="deleteMe">
  <h4 class=text-center> No Results Found </h4>
  <h5 class=text-center> Try setting your location on your profile </h5>
  </div>
<div id="cards" class="row m-3"></div>
</div>
</body>
<script src="index.js"></script>

</html>

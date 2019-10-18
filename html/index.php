<?php
$page = "index";
include("pageSetup.php");

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: welcome");
    exit;
}


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
$sql = "SELECT * FROM `requests` WHERE `username`!='".$_SESSION['username']."' LIMIT 100";
$result = $mysqli->query($sql);
$toPrint = "<script> window.onload = function() {";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (in_array($row['id'], $joined)) {
          $toPrint .= 'addCardJoined("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        } else {
          $toPrint .= 'addCard("'.$row['username'].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'");';
        }
    }
    $toPrint .= " }; </script>";
    echo $toPrint;
}

$mysqli->close();
?>

<div id="cards" class="row m-3"></div>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>

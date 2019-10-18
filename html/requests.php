<?php
$page = "tickets";
include('pageSetup.php');

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
        $toPrint .= 'addCardRequest("'.$joinNames[$x].'", "'.$row['media'].'", "'. $row['platform'].'", "'.$row['whenToWatch'].'", "'.$joinRequests[$x].'");';
      }
  }
}
$toPrint .= " }; </script>";
echo $toPrint;
$mysqli->close();
?>

<div class="my-5">
<div id="sendRequest">
  <form id="watchRequest" method="post" action="add.php">
    <h3> Watch Request </h3>
    <div class="form-group">
      <label for="showInput">What do you want to watch? </label>
      <input required autocomplete="off" type="text" class="form-control" name="show" id="showInput" size="50" placeholder="The Office, Good Omens, Death Note">
    </div>

    <div class="form-group">
      <label for="platformInput">What to watch it on? </label>
      <select name="platform" id="platformInput" class="platform-select">
        <option selected>Platform</option>
        <option value="netflix">Netflix</option>
        <option value="hulu">Hulu</option>
        <option value="youtube">YouTube</option>
        <option value="amazon">Amazon</option>
      </select>
    </div>

    <div class="form-group">
      <label for="whenInput">When do you want to watch? </label>
      <input required name="when" type="text" class="form-control" id="whenInput" size="50" placeholder="Tonight, This Week, Thursday">
    </div>
    <button type="submit" class="btn btn-primary binge-red-bg ">Add to Box Office</button>
  </form>
</div>
  <div id="cards" class="row m-3"></div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>

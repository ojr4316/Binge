<?php

if(!empty($_GET['term'])){
session_start();
require_once "config.php";

$states = array();
$sql = "SELECT * FROM US_STATES";
$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
while($row=mysqli_fetch_array($result)){
  array_push($states, $row['STATE_CODE']);
}

$term = $_GET['term'];
$term = mysqli_real_escape_string($mysqli, $term);
$output = array();

$sql = "SELECT * FROM US_CITIES WHERE CITY LIKE '" . $term . "%' LIMIT 10;";

$result = mysqli_query($mysqli,$sql) or die(mysqli_error());

while($row=mysqli_fetch_array($result)){
  $output[] = $row['CITY'].", ".$states[$row['ID_STATE'] - 1]."(".$row["ID"].")";
}
mysqli_close($mysqli);
echo json_encode($output);
}
?>

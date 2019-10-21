<?php

if(!empty($_GET['term'])){
session_start();
require_once "config.php";

$term = $_GET['term'];
$term = mysqli_real_escape_string($mysqli, $term);
$output = array();

$sql = "SELECT * FROM colleges WHERE institution_name LIKE '" . $term . "%' LIMIT 10;";

$result = mysqli_query($mysqli,$sql) or die(mysqli_error());

while($row=mysqli_fetch_array($result)){
$output[] = $row['institution_name'];
}
mysqli_close($mysqli);
echo json_encode($output);
}
?>

<?php
session_start();
require_once "config.php";

if (isset($_GET["query"])) {
  $response = file_get_contents('https://api.themoviedb.org/3/search/multi?api_key=1e94de5ed2dc8e3c7ef6674f1d7b6822&language=en-US&region=US&query='.$_GET["query"].'&page=1&include_adult=false');
} else {
  $response = file_get_contents('https://api.themoviedb.org/3/movie/now_playing?api_key=1e94de5ed2dc8e3c7ef6674f1d7b6822&language=en-US&page=1');
}

$response = json_decode($response, true);
$stuff = array();

for ($i = 0; $i < count($response["results"]); $i++) {
  $mov = (object)[];
  $mov->id = $response["results"][$i]["id"];
  if (array_key_exists("title", $response["results"][$i])){
    $mov->title = $response["results"][$i]["title"];
  } else if (array_key_exists("name", $response["results"][$i])){
    $mov->title = $response["results"][$i]["name"];
  }
  $mov->overview = $response["results"][$i]["overview"];
  $mov->poster_path = $response["results"][$i]["poster_path"];
  array_push($stuff, $mov);
}

echo json_encode(array_values($stuff));

?>

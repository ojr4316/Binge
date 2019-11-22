<?php

function getStressLevel($level) {
  switch ($level) {
    case 28:
    return 5;
    break;
    case 12:
    return 4;
    break;
    case 16:
    return 3;
    break;
    case 35:
    return 1;
    break;
    case 80:
    return 5;
    break;
    case 99:
    return 2;
    break;
    case 18:
    return 4;
    break;
    case 10751:
    return 3;
    break;
    case 14:
    return 3;
    break;
    case 36:
    return 2;
    break;
    case 27:
    return 5;
    break;
    case 10402:
    return 2;
    break;
    case 9648:
    return 4;
    break;
    case 10749:
    return 3;
    break;
    case 878:
    return 3;
    break;
    case 10770:
    return 3;
    break;
    case 53:
    return 5;
    break;
    case 10752:
    return 5;
    break;
    case 37:
    return 4;
    break;
    default:
    return 3;
    break;
  }
}

require_once "config.php";

for ($z = 0; $z < 500; $z++) {
$response = file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key=1e94de5ed2dc8e3c7ef6674f1d7b6822&region=US&language=en-US&page='.$z);
$response = json_decode($response, true);
$stuff = array();
for ($i = 0; $i < count($response["results"]); $i++) {
$sql = "INSERT INTO movies (name, id, sum, total, date) VALUES (?, ?, ?, ?, ?)";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("siiis", $nameParam, $idParam, $sumParam, $totalParam, $dateParam);

    $idParam = $response["results"][$i]["id"];
    if (array_key_exists("title", $response["results"][$i])){
      $nameParam = $response["results"][$i]["title"];
    } else if (array_key_exists("name", $response["results"][$i])){
      $nameParam = $response["results"][$i]["name"];
    }

    $sumParam = 0;
    for ($x = 0; $x < count($response["results"][$i]["genre_ids"]); $x++) {
      $sumParam += getStressLevel($response["results"][$i]["genre_ids"][$x]);
    }

    $sumParam /= count($response["results"][$i]["genre_ids"]);
    $totalParam = 1;
    $dateParam = $response["results"][$i]["release_date"];

    if($stmt->execute()){
    }else{
        echo("Statement failed: ". $stmt->error . "<br>");
        echo "Something went wrong. Please try again later.";
    }
}
$stmt->close();
}
}
$mysqli->close();
?>

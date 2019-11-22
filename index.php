<?php
$page = "index";
include("pageSetup.php");

// Get Joined Requests
$joined = array();
$sql = 'SELECT * FROM `joinRequests` WHERE `joinUsername`="' . $_SESSION['username'] . '"';
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($joined, $row['requestId']);
    }
}

// Get User's Request
$toPrint = "<script> window.onload = function() {";

$sql = "SELECT
  ANY_VALUE(`id`),
  ANY_VALUE(`username`),
  ANY_VALUE(`media`),
  ANY_VALUE(`location`),
  ANY_VALUE(`college`),
  ANY_VALUE(`coord_lat`),
  ANY_VALUE(`coord_long`),
  ANY_VALUE(`img`),
  ANY_VALUE(`summary`),
  `mediaId`,
  COUNT(`mediaId`) AS `occurs`
FROM
  requests
WHERE
  (
    3959 * acos(
      cos(radians(" . $_SESSION['coord_lat'] . ")) * cos(radians(`coord_lat`)) * cos(radians(`coord_long`) - radians(" . $_SESSION['coord_long'] . ")) + sin(radians(" . $_SESSION['coord_lat'] . ")) * sin(radians(`coord_lat`))
    )
  ) < 25
  OR `college` = '" . $_SESSION['college'] . "'
GROUP BY
  `mediaId`
ORDER BY
  `occurs` DESC
LIMIT
  100";

$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['occurs'] > 1 && $row['ANY_VALUE(`username`)'] != $_SESSION["username"]) { // Instead of listing all results, lets create a special card
            $toPrint .= 'addPopularCard("' . $row['ANY_VALUE(`username`)'] . '", "' . $row['ANY_VALUE(`media`)'] . '", "' . $row['ANY_VALUE(`id`)'] . '", "' . $row['ANY_VALUE(`img`)'] . '", "' . $row['ANY_VALUE(`summary`)'] . '");';
        } else {
            if ($row['ANY_VALUE(`username`)'] == $_SESSION['username']) {
                $toPrint .= 'addYourCard("' . $row['ANY_VALUE(`username`)'] . '", "' . $row['ANY_VALUE(`media`)'] . '", "' . $row['ANY_VALUE(`id`)'] . '", "' . $row['ANY_VALUE(`img`)'] . '", "' . $row['ANY_VALUE(`summary`)'] . '");';
            } else {
                if (in_array($row['ANY_VALUE(`id`)'], $joined)) {
                    $toPrint .= 'addCardJoined("' . $row['ANY_VALUE(`username`)'] . '", "' . $row['ANY_VALUE(`media`)'] . '", "' . $row['ANY_VALUE(`id`)'] . '", "' . $row['ANY_VALUE(`img`)'] . '", "' . $row['ANY_VALUE(`summary`)'] . '");';
                } else {
                    $toPrint .= 'addCard("' . $row['ANY_VALUE(`username`)'] . '", "' . $row['ANY_VALUE(`media`)'] . '", "' . $row['ANY_VALUE(`id`)'] . '", "' . $row['ANY_VALUE(`img`)'] . '", "' . $row['ANY_VALUE(`summary`)'] . '");';
                }
            }

        }
    }
}

$toPrint .= " if ($('#cards').children().length > 0) { $('#deleteMe').remove(); } resizeTickets(); removeExtra(); }; </script>";
echo $toPrint;

$mysqli->close();
// TODO: School/Local Events
//         <img class="rounded mx-auto d-block" src="https://image.tmdb.org/t/p/w500/5myQbDzw3l8K9yofUXRJ4UTVgam.jpg"/>
?>

<div class="container-fluid h-100">
    <div class="mt-3" id="deleteMe">
        <h4 class="text-center text-white"> No Results Found </h4>
        <h5 class="text-center text-white"> Try setting your location on your profile </h5>
    </div>
    <div id="schoolEvents">
    </div>

    <h3 class="text-white mt-5 ml-5" id="popularLabel"> Popular near you </h3>
    <div id="popular" class="row mx-5"></div>
    <h3 class="text-white mt-5 ml-5" id="nearYouLabel"> What people want to watch near you </h3>
    <div id="cards" class="row mx-5 "></div>

</div>

<footer class="binge-red-bg p-3">
    <div style="float:left;">
        <p class="mb-0 text-white p-3"> Binge does not own any rights to any of the movies
            or shows displayed </p>
    </div>
    <div style="float:right;">
        <img src="img/themoviedb.png" style="display: inline-block; height: 4em;"> </img>
    </div>
    <div style="clear: left;"></div>
</footer>
</body>

</html>

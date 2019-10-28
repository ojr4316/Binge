<?php
include("pageSetup.php");

$user = -1;
if (isset($_GET["user"])) {
  $user = $_GET["user"];
} else {
  header('Refresh:0 , url=/');
  exit();
}

// Populate Profile
$email = "";
$college = "";
$availability = "";

$sql = "SELECT * FROM `users` WHERE username='$user'" ;
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $college = $row["college"];
        $location = $row["location"];
        $availability = json_decode($row["availability"]);
    }
}

if ($college == "") {
    $college = "None";
}

if ($location == "") {
  $location = "None";
}

// Get User's Request
$sql = "SELECT * FROM `requests` WHERE `username`='".$user."'";
$result = $mysqli->query($sql);
$toPrint = "<script> window.onload = function() {";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if ($row['username'] == $_SESSION["username"]) {
        $toPrint .= 'addCardProfile("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
    } else {
      $toPrint .= 'addCard("'.$row['username'].'", "'.$row['media'].'", "'.$row['whenToWatch'].'", "'.$row['id'].'", "'.$row['img'].'", "'.$row['summary'].'");';
    }
    }
    $toPrint .= "  resizeTickets(); }; </script>";
    echo $toPrint;
} else {
  echo "<script> window.onload = function() { $('.container').append('<div class=binge-white-box><div class=m-5><h4 class=text-center> No Tickets Found </h4></div></div>'); }; </script>";
}
$mysqli->close();
?>
<div class="container">
  <div class="binge-white-box m-5 text-center">
  <h3 class="pt-2"><b><?php echo $user;?></b></h3>
  <p> Location: <span class="binge-red" id="locationInput"><?php echo $location; ?></span><?php if ($user == $_SESSION["username"]) { echo'<i style="font-size: 1em;" id="editLocation" class="fas fa-pencil-alt binge-red ml-1"></i>'; } ?></p>
  <p > School: <span class="binge-red" id="collegeInput"><?php echo $college; ?></span><?php if ($user == $_SESSION["username"]) { echo'<i style="font-size: 1em;" id="editCollege" class="fas fa-pencil-alt binge-red ml-1"></i>'; } ?></p>

    <div class="alert alert-success" role="alert" style="display: none;"> Availability updated! </div>

    <div class="weekDays-selector">
      <input type="checkbox" id="weekday-mon" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[0] == "true") { echo "checked"; } ?>/>
      <label for="weekday-mon">M</label>
      <input type="checkbox" id="weekday-tue" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[1] == "true") { echo "checked"; } ?>/>
      <label for="weekday-tue">T</label>
      <input type="checkbox" id="weekday-wed" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[2] == "true") { echo "checked"; } ?>/>
      <label for="weekday-wed">W</label>
      <input type="checkbox" id="weekday-thu" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[3] == "true") { echo "checked"; } ?>/>
      <label for="weekday-thu">T</label>
      <input type="checkbox" id="weekday-fri" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[4] == "true") { echo "checked"; } ?>/>
      <label for="weekday-fri">F</label>
      <input type="checkbox" id="weekday-sat" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[5] == "true") { echo "checked"; } ?>/>
      <label for="weekday-sat">S</label>
      <input type="checkbox" id="weekday-sun" class="weekday" <?php if ($user != $_SESSION["username"]) { echo "disabled"; } ?> <?php if ($availability[6] == "true") { echo "checked"; } ?>/>
      <label for="weekday-sun">S</label>
    </div>
    <?php
    if ($user == $_SESSION["username"]) {
      echo '<button style="background-color: white;" onclick="setAvil()" class="btn card-button mt-auto binge-red mb-3">Change Availability</button>';
    }
    ?>
  </div>
  <div id="cards" class="row m-3"></div>
</div>
</body>
<script src="index.js"></script>
<script>

function setAvil() {
  $.ajax({ url: '/setavailability.php',
              type: 'POST',
              data: {"days": [$("#weekday-mon").is(":checked"), $("#weekday-tue").is(":checked"), $("#weekday-wed").is(":checked"), $("#weekday-thu").is(":checked"), $("#weekday-fri").is(":checked"), $("#weekday-sat").is(":checked"), $("#weekday-sun").is(":checked")]},
              error:function(exception){alert('Exception:'+exception);}
  });

  $(".alert").css("display", "");
  setTimeout(function() {
    $(".alert").css("display", "none");
  }, 2000);

}

$(document).delegate('#editCollege', 'click', function() {
    var input = $("<input id='collegeInput'>", { val: $('#collegeInput').text(),
                               type: "text" });
    $("#collegeInput").replaceWith(input);
    input.select();

    $("#collegeInput").autocomplete({source:"collegecomplete.php", select: function (event, ui) {
      var span = $("<span class='binge-red' id='collegeInput'>");
      span.text(ui.item.label);
      $("#collegeInput").replaceWith(span);
      span.select();
      $.ajax({ url: '/setcollege.php',
                  type: 'POST',
                  data: {"college": ui.item.label},
                  error:function(exception){alert('Exception:'+exception);}
      });
    }
   });
});

$(document).delegate('#editLocation', 'click', function() {
    var input = $("<input id='locationInput'>", { val: $('#locationInput').text(),
                               type: "text" });
    $("#locationInput").replaceWith(input);
    input.select();

    $("#locationInput").autocomplete({source:"citycomplete.php", select: function (event, ui) {
      var span = $("<span class='binge-red' id='locationInput'>");
      $("#locationInput").replaceWith(span);
      span.select();
      $.ajax({ url: '/setlocation.php',
                  type: 'POST',
                  data: {"location": ui.item.label},
                  error:function(exception){alert('Exception:'+exception);}
      });
      span.text(ui.item.label.slice(0, ui.item.label.indexOf("(")));
    }
   });
});

</script>
</html>

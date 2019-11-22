<?php
$page = "user";
include("pageSetup.php");

$user = -1;
if (isset($_GET["user"]) && ctype_alnum($_GET["user"])) {
    $user = trim($_GET["user"]);
} else {
    header('Refresh:0 , url=/');
    exit();
}

// Populate Profile
$email = "";
$college = "None";
$location = "None";
$availability = "";

$sql = "SELECT * FROM `users` WHERE username='$user'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $college = $row["college"];
        $location = $row["location"];
        $availability = json_decode($row["availability"]);
    }
}

// Get User's Request
$sql = "SELECT * FROM `requests` WHERE `username`='" . $user . "'";
$result = $mysqli->query($sql);
$toPrint = "<script> window.onload = function() {";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['username'] == $_SESSION["username"]) {
            $toPrint .= 'addCardProfileYours("' . $row['username'] . '", "' . $row['media'] . '", "' . $row['id'] . '", "' . $row['img'] . '", "' . $row['summary'] . '");';
        } else {
            $toPrint .= 'addCardProfile("' . $row['username'] . '", "' . $row['media'] . '", "' . $row['id'] . '", "' . $row['img'] . '", "' . $row['summary'] . '");';
        }
    }
}

$sql = "SELECT * FROM `watched` WHERE `username`='" . $user . "'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['username'] == $_SESSION["username"]) {
            $toPrint .= 'addWatchedYours("' . $row['media_id'] . '", "' . $row['title'] . '", "' . $row['img'] . '");';
        } else {
            $toPrint .= 'addWatched("' . $row['media_id'] . '", "' . $row['title'] . '", "' . $row['img'] . '");';
        }
    }
}
$toPrint .= "  resizeTickets(); removeExtraProfile(); }; </script>";
echo $toPrint;

$mysqli->close();

// On other users profile
$imgDir = "default.png";
if (file_exists("uploads/" . $user . ".png")) {
    $imgDir = "uploads/" . $user . ".png";
}
// Profile Image Stuff
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "something";
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check == false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $_SESSION["username"] . ".png")) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "not good";
        }
    }
}
?>
<div class="container">
    <div class="row">
        <div class="binge-white-box mt-2 p-5 text-center mx-auto" class="col">
            <div class="view overlay profile-img-container">
                <img class='profile-img' src='<?php echo $imgDir; ?>'/>
                <?php
                if ($user == $_SESSION["username"]) {
                    echo '<div class="mask flex-center">
          <form style="all:unset" id="imgForm" action="" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" style="display:none;" accept="image/png, image/jpeg"/>
            <br>
            <label class="btn card-button mt-auto binge-red-bg text-white mt-3" for="fileToUpload">Change Image</label>
          </form>
        </div>';
                }
                ?>
            </div>


            <h3 class="pt-2"><b><?php echo $user; ?></b></h3>
            <p> Location: <span class="binge-red"
                                id="locationInput"><?php echo $location; ?></span><?php if ($user == $_SESSION["username"]) {
                    echo '<i style="font-size: 1em;" id="editLocation" class="fas fa-pencil-alt binge-red ml-1"></i>';
                } ?></p>
            <p> School: <span class="binge-red"
                              id="collegeInput"><?php echo $college; ?></span><?php if ($user == $_SESSION["username"]) {
                    echo '<i style="font-size: 1em;" id="editCollege" class="fas fa-pencil-alt binge-red ml-1"></i>';
                } ?></p>

            <div class="alert alert-success" role="alert" style="display: none;"> Availability updated!</div>

            <div class="weekDays-selector mt-2">
                <input type="checkbox" id="weekday-mon" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[0] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-mon">M</label>
                <input type="checkbox" id="weekday-tue" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[1] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-tue">T</label>
                <input type="checkbox" id="weekday-wed" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[2] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-wed">W</label>
                <input type="checkbox" id="weekday-thu" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[3] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-thu">T</label>
                <input type="checkbox" id="weekday-fri" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[4] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-fri">F</label>
                <input type="checkbox" id="weekday-sat" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[5] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-sat">S</label>
                <input type="checkbox" id="weekday-sun" class="weekday" <?php if ($user != $_SESSION["username"]) {
                    echo "disabled";
                } ?> <?php if ($availability[6] == "true") {
                    echo "checked";
                } ?>/>
                <label for="weekday-sun">S</label>
            </div>
            <?php
            if ($user == $_SESSION["username"]) {
                echo '<button style="background-color: white;" onclick="setAvil()" class="btn card-button mt-auto binge-red mb-3">Change Availability</button>';
            }
            ?>
        </div>
        <div class="col">
            <h3 class="text-white mt-2" id="watchLabel"> Wants to watch </h3>
            <div id="cards" style="overflow-x: auto; overflow-y: hidden;"></div>
            <h3 class="text-white mt-2" id="watchedLabel"> Has watched </h3>
            <div id="watched" style="overflow-x: auto; overflow-y: hidden;"></div>
        </div>
    </div>

</div>
</body>
<script src="index.js"></script>
<script>

    document.getElementById("fileToUpload").onchange = function () {
        document.getElementById("imgForm").submit();
    };

    function setAvil() {
        $.ajax({
            url: '/setavailability.php',
            type: 'POST',
            data: {"days": [$("#weekday-mon").is(":checked"), $("#weekday-tue").is(":checked"), $("#weekday-wed").is(":checked"), $("#weekday-thu").is(":checked"), $("#weekday-fri").is(":checked"), $("#weekday-sat").is(":checked"), $("#weekday-sun").is(":checked")]},
            error: function (exception) {
                alert('Exception:' + exception);
            }
        });

        $(".alert").css("display", "");
        setTimeout(function () {
            $(".alert").css("display", "none");
        }, 2000);

    }

    $(document).delegate('#editCollege', 'click', function () {
        var input = $("<input id='collegeInput'>", {
            val: $('#collegeInput').text(),
            type: "text"
        });
        $("#collegeInput").replaceWith(input);
        input.select();

        $("#collegeInput").autocomplete({
            source: "collegecomplete.php", select: function (event, ui) {
                var span = $("<span class='binge-red' id='collegeInput'>");
                span.text(ui.item.label);
                $("#collegeInput").replaceWith(span);
                span.select();
                $.ajax({
                    url: '/setcollege.php',
                    type: 'POST',
                    data: {"college": ui.item.label},
                    error: function (exception) {
                        alert('Exception:' + exception);
                    }
                });
            }
        });
    });

    $(document).delegate('#editLocation', 'click', function () {
        var input = $("<input id='locationInput'>", {
            val: $('#locationInput').text(),
            type: "text"
        });
        $("#locationInput").replaceWith(input);
        input.select();

        $("#locationInput").autocomplete({
            source: "citycomplete.php", select: function (event, ui) {
                var span = $("<span class='binge-red' id='locationInput'>");
                $("#locationInput").replaceWith(span);
                span.select();
                $.ajax({
                    url: '/setlocation.php',
                    type: 'POST',
                    data: {"location": ui.item.label},
                    error: function (exception) {
                        alert('Exception:' + exception);
                    }
                });
                span.text(ui.item.label.slice(0, ui.item.label.indexOf("(")));
            }
        });
    });

</script>
</html>

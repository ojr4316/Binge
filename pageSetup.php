<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /welcome");
    exit;
}

// Get Profile Image
$imgDir = "default.png";
if (file_exists("uploads/" . $_SESSION["username"] . ".png")) {
    $imgDir = "uploads/" . $_SESSION["username"] . ".png";
}

// Get Requests (Ticket Badge)
$amountOfRequests = 0;
$sql = "SELECT * FROM `joinRequests` WHERE `showTo`='" . $_SESSION["username"] . "'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $amountOfRequests += 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Binge</title>
    <base href="/"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A social media based around watching with others"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/css/mdb.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
        integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<body>
<div class="popcornBg"></div>
<nav class="navbar navbar-expand-lg navbar-dark binge-red-bg">
    <a class="navbar-brand" href="/"><h1 class="text-white nav-title title-anim"> Binge </h1></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item splat-anim <?php if ($page == 'index') {
                echo "active";
            } ?>">
                <a class="text-white nav-link" href="/"> Near Me <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item splat-anim <?php if ($page == 'tickets') {
                echo "active";
            } ?>">
                <a class="text-white nav-link" href="requests">
                    Invites <?php echo '<span class="badge badge-light">' . $amountOfRequests . '</span>'; ?> </a>
            </li>
        </ul>

        <form class="form-inline ml-5" method="get" action="create">
            <input class="form-control mr-sm-2" type="search" name="q" value="" placeholder="Search"
                   aria-label="Search">
            <button class="btn btn-outline-success text-white my-2 my-sm-0" type="submit">Search</button>
        </form>

        <ul class="navbar-nav ml-auto m-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class='profile-img-small'
                                                                                          src='<?php echo $imgDir; ?>'/></a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a href="user/<?php echo htmlspecialchars($_SESSION["username"]); ?>" class="dropdown-item">View
                        Profile</a>
                    <a href="reset-password" class="dropdown-item">Change Password</a>
                    <a href="feedback" class="dropdown-item">Send Feedback</a>
                    <a href="logout" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div id="bottomChat">
    <button class="btn m-3 binge-red-bg text-white" type="button" data-toggle="collapse" data-target="#chatStuff"
            aria-expanded="false"
            aria-controls="chatStuff">Chat
    </button>
    <div id="chatStuff" class="collapse">
        <div id="chatbox">
            <form class="chatForm" id="chat" autocomplete="off">
                <div id="chatSelect"></div>
                <div style="white-space:pre-wrap; overflow-y: scroll; overflow-wrap: break-word;" id="chatArea"
                     class="form-control"></div>
                <input autocomplete="off" id="textToAdd" type="text"/>
                <button id="sendButton" class="binge-red-bg chat-button" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>

<script src="index.js"></script>

<?php
// Get chat partners
$chatPrint = "<script> $(document).ready(function() { ";
$sql = "SELECT * FROM chats WHERE userOne = '" . $_SESSION['username'] . "' OR userTwo = '" . $_SESSION["username"] . "'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['userOne'] == $_SESSION["username"]) {
            $chatPrint .= 'addChatOption("' . $row['id'] . '", "' . $row['userTwo'] . '");';
        } else {
            $chatPrint .= 'addChatOption("' . $row['id'] . '", "' . $row['userOne'] . '");';
        }
    }
}
$chatPrint .= " setValueI($('.chat-button').val()); update(); }); </script>";
echo $chatPrint;
?>
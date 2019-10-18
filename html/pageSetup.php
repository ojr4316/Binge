<?php
session_start();
require_once "config.php";
$amountOfRequests = 0;
$sql = "SELECT * FROM `joinRequests` WHERE `showTo`='".$_SESSION["username"]."'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $amountOfRequests += 1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Binge</title>
    <base href="/" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<body class="popcornBg">
  <nav class="navbar navbar-expand-lg navbar-dark binge-red-bg">
  <a class="navbar-brand" href="#"><h1 class="text-white nav-title"> Binge </h1></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item <?php if ($page == 'index') { echo "active"; }?>">
        <a class="text-white nav-link" href="/">Box Office <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php if ($page == 'tickets') { echo "active"; }?>">
        <a class="text-white nav-link" href="requests">Tickets <?php echo '<span class="badge badge-light">'.$amountOfRequests.'</span>'; ?> </a>
      </li>
      <li class="nav-item <?php if ($page == 'chats') { echo "active"; }?>">
        <a class="text-white nav-link" href="chat">Chats</a>
      </li>

    </ul>
    <ul class="navbar-nav ml-auto topnav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Welcome, <?php echo htmlspecialchars($_SESSION["username"]);?></a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a href="user/<?php echo htmlspecialchars($_SESSION["username"]);?>" class="dropdown-item">View Profile</a>
          <a href="reset-password" class="dropdown-item">Change Password</a>
          <a href="logout" class="dropdown-item">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

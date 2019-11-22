<?php
if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
    header("location: /");
    exit;
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
<body>
  <div class="popcornBg"></div>
  <header class="header" id="header">
    <div class="skew">
        <div class="header-inner">
          <h1 class="logo text-white title-anim p-3">Binge</h1>
        </div>
    </div>
  </header>

  <div id="filler"></div>

<div id="content1" class="p-3 container w3-animate-left binge-plain-white-box mx-auto text-center" style="opacity: 0.95;">
  <div class="col mx-auto text-center">
      <div class="row pt-5 pb-5 no-pad-small">
          <div class="col-lg lil-pad-small">
              <i style="animation-delay: 0.2s" class="fas fa-video binge-red spin-anim icon-pad"></i>
              <h3 class="binge-red"> Create </h3>
              <p class="binge-red col-text"> Find anything you'd like to watch </p>
          </div>

          <div class="col-lg ml-3 lil-pad-small">
              <i style="animation-delay: 0.4s" class="fas fa-ticket-alt binge-red spin-anim icon-pad"></i>
              <h3 class="binge-red"> Explore </h3>
              <p class="binge-red col-text"> View watch requests from other users </p>
          </div>

          <div class="col-lg ml-3 lil-pad-small">
              <i style="animation-delay: 0.6s" class="fas fa-comments binge-red spin-anim icon-pad"></i>
              <h3 class="binge-red"> Chat </h3>
              <p class="binge-red col-text"> Make plans for your next binge session </p>
          </div>
      </div>
    </div>
    <hr class="mr-5">
    <button type="button" onclick="window.location.href = 'login';" class="btn btn-outline-primary welcome-page-button">Sign In</button>
    <button type="button" onclick="window.location.href = 'register';" class="btn btn-outline-primary welcome-page-button">Get Started</button>
</div>

</body>
</html>

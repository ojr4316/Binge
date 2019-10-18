<?php
if(!isset($_SESSION)){
  session_start();
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}

if(isset($_SESSION["email"])){
    header("location: index");
    exit;
}


require_once "config.php";

$new_email = $new_img = "";
$new_email_err = $new_img_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["new_email"]))){
        $new_email_err = "Please enter the new email.";
    } else {
        $new_email = trim($_POST["new_email"]);
    }

    if (!empty(trim($_POST["new_img"]))) {
      $new_img = $_POST["new_img"];
    }

    if(empty($new_email_err) && empty($new_img_err)){
        $sql = "UPDATE users SET image = ?, email = ? WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("bsi", $param_image, $param_email, $param_id);

            $param_email = $new_email;
            $param_image = $new_img;
            $param_id = $_SESSION["id"];

            if($stmt->execute()){
                $_SESSION["email"] = $param_email;
                $_SESSION["image"] = $param_image;
                header("location: index");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Binge</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/css/mdb.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <h2>Just a few more questions</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Change Account Email</label>
                <input type="email" name="new_email" class="form-control" value="<?php echo $new_email; ?>">
                <label> Upload picture </label>
                <input type="file" name="new_img" value="<?php echo $new_img; ?>"></input>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
      </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="index.js"></script>
</html>

<?php
session_start(); 
require_once __DIR__."/../config/app.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $appInfo['lang']?>" dir="<?php echo $appInfo['dir']?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $appInfo['appName'] . " | " . $title?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        .custom-card-header {

            height: 400px;
            background-size: cover;
            background-position: center;

        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow">
    <a class="navbar-brand" href="<?php echo $appInfo['appUrl'];?>"><?php echo $appInfo['appName'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $appInfo['appUrl'];?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $appInfo['appUrl'];?>contact.php">Contact Us</a>
        </li>
      </ul>
      
      <ul class="navbar-nav ml-auto">
      <?php if(!isset($_SESSION['isLoggedIn'])) { ?>
      
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $appInfo['appUrl'];?>register.php">Register</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo $appInfo['appUrl'];?>login.php">Log in</a>
          </li>

      <?php } else { ?>
          
          <li class="nav-item">
            <a class="nav-link" href="#"><?php echo $_SESSION['userName'];?></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo $appInfo['appUrl'];?>logout.php">Log out</a>
          </li>

      <?php } ?>

      </ul>
    </div>
</nav>

<div class="container pt-5">
<?php include './template/welcomeMessage.php'; ?>
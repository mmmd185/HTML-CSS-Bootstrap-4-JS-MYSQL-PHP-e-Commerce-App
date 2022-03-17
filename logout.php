<?php 

session_start();

if (isset($_SESSION['isLoggedIn'])) {


    $_SESSION = [];
    $_SESSION['welcomeMessage'] = 'See you soon!';
    header('location: index.php');
    die();

}
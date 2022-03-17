<?php

$title = "Change Password";
require_once "template/header.php";
require "./classes/Service.php";
require "./config/app.php";
require_once "./config/db.php";
include './template/filters.php';


if(isset($_SESSION['isLoggedIn'])) {

    header('location: index.php');
    die();

}    


if(!isset($_GET['token']) || !$_GET['token']){

    die();

}


$now = date("Y-m-d H:i:s");

$tokenCheckQuery = $mySqli->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > '$now'");

$tokenCheckQuery->bind_param('s', $token);

$token = $_GET['token'];

$tokenCheckQuery->execute();

$tokenCheckQueryResult = $tokenCheckQuery->get_result();


if (!$tokenCheckQueryResult->num_rows) {

    die('error');

}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userPassword = mysqli_real_escape_string($mySqli, filterString($_POST['password']));
    $userPasswordConfirmation = mysqli_real_escape_string($mySqli, filterString($_POST['passwordConfirmation']));

    if(empty($userPassword)) {array_push($errors, 'Password is Required');}
    if(empty($userPasswordConfirmation)) {array_push($errors, 'Password Confirmation is Required');}
    if($userPassword != $userPasswordConfirmation) { array_push($errors, 'Passwords do not match');}


    if(!count($errors)) {

        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        $userId = $tokenCheckQueryResult->fetch_assoc()['user_id'];

        $mySqli->query("UPDATE users SET user_password = '$hashedPassword' WHERE id = '$userId'");

        $mySqli->query("DELETE FROM password_resets WHERE user_id = '$userId'");

        header('location: login.php');

        $_SESSION['welcomeMessage'] = "Your Password has been changed, please login!";

        die();


    }


}


?>


<div id="changePassword">
    <?php include './template/errors.php'; ?>
    <h5 class="text-info">Change Password</h5>
    <hr>
    <form method="POST">

        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" placeholder="Your new password" class="form-control">
        </div>

        <div class="form-group">
            <label for="passwordConfirmation">Confirm Password:</label>
            <input type="password" name="passwordConfirmation" id="passwordConfirmation" placeholder="Confirm new password" class="form-control">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Change password!</button>
        </div>

    </form>

</div>


<?php require_once './template/footer.php'; ?>
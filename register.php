<?php

$title = "Registration";
require_once "template/header.php";
require "./classes/Service.php";
require "./config/app.php";
require_once "./config/db.php";
include './template/filters.php';


if(isset($_SESSION['isLoggedIn'])) {


    header('location: index.php');
    die();

}    


$errors = [];
$username = '';
$userEmail = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = mysqli_real_escape_string($mySqli, filterString($_POST['username']));
    $userEmail = mysqli_real_escape_string($mySqli, filterEmail($_POST['email']));
    $userPassword = mysqli_real_escape_string($mySqli, filterString($_POST['password']));
    $userPasswordConfirmation = mysqli_real_escape_string($mySqli, filterString($_POST['passwordConfirmation']));

    if(empty($username)) {array_push($errors, 'Username is Required');}
    if(empty($userEmail)) {array_push($errors, 'Email is Required');}
    if(empty($userPassword)) {array_push($errors, 'Password is Required');}
    if(empty($userPasswordConfirmation)) {array_push($errors, 'Password Confirmation is Required');}
    if($userPassword != $userPasswordConfirmation) {array_push($errors, 'Passwords do not match');}



    if(!count($errors)) {

        $userExists = $mySqli->query("select id, email from users where email = '$email' limit 1");

        if($userExists->num_rows) {

            array_push($errors, 'email already registered');

        }

        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        $newUserQuery = "INSERT INTO users (username, user_password, email, role) VALUES ('$username', '$userPassword', '$userEmail', 'user')";

        $mySqli->query($newUserQuery);

        $_SESSION['userId'] = $mySqli->insert_id;

        $_SESSION['isLoggedIn'] = true;

        $_SESSION['userName'] = $username;

        $_SESSION['welcomeMessage'] = "Welcome to our website, $username !";

        header('location: index.php');
        die();
    
    }


}


?>


<div id="register">
    <?php include './template/errors.php'; ?>
    <h4>Welcome to our website!</h4>
    <h5 class="text-info">Please fill in the form below to register</h5>
    <hr>
    <form method="POST">

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Your Username" class="form-control" value="<?php echo $username;?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" value="<?php echo $userEmail;?>">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Your Password" class="form-control">
        </div>

        <div class="form-group">
            <label for="passwordConfirmation">Confirm Password:</label>
            <input type="password" name="passwordConfirmation" id="passwordConfirmation" placeholder="Confirm Your Password" class="form-control">
        </div>

        <div class="form-group">
            <button class="btn btn-success">Register!</button>
            <a href="login.php">Already have an account? please login here</a>
        </div>

    </form>

</div>


<?php require_once './template/footer.php'; ?>
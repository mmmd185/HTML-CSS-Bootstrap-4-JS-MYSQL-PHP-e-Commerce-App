<?php

$title = "Password Reset";
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
$userEmail = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userEmail = mysqli_real_escape_string($mySqli, filterEmail($_POST['email']));

    if(empty($userEmail)) {array_push($errors, 'Email is Required');}


    if(!count($errors)) {

        $userExists = $mySqli->query("select id, email from users where email = '$userEmail' limit 1");

        if ($userExists->num_rows) {

            $userId = $userExists->fetch_assoc()['id'];

            $tokenExists = $mySqli->query("DELETE FROM password_resets WHERE user_id = '$userId'");

            $token = bin2hex(random_bytes(16));

            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day'));

            $mySqli->query("INSERT INTO password_resets (user_id, token, expires_at) VALUES ('$userId', '$token', '$expiresAt')");

        }


        $_SESSION['welcomeMessage'] = 'Please check your email for the reset link';

        header('location: passwordReset.php');

        die();


    }


}


?>


<div id="passwordReset">
    <?php include './template/errors.php'; ?>
    <h5 class="text-info">Please fill in your email to reset your password</h5>
    <hr>
    <form method="POST">


        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" value="<?php echo $userEmail;?>">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Request Password Reset Link!</button>
        </div>

    </form>

</div>


<?php require_once './template/footer.php'; ?>
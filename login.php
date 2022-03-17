<?php

$title = "Login";
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
    $userPassword = mysqli_real_escape_string($mySqli, filterString($_POST['password']));

    if(empty($userEmail)) {array_push($errors, 'Email is Required');}
    if(empty($userPassword)) {array_push($errors, 'Password is Required');}


    if(!count($errors)) {


        $userExists = $mySqli->query("select id, username, email, user_password, role from users where email = '$userEmail' limit 1");

        if(!$userExists->num_rows) {

            array_push($errors, 'Wrong Credentials');

        } else {


            $foundUser = $userExists->fetch_assoc();

            if (!password_verify($userPassword, $foundUser['user_password'])){ 

                array_push($errors, 'Wrong Credentials');

            } else {
                

                $_SESSION['userId'] = $foundUser['id'];

                $_SESSION['isLoggedIn'] = true;
        
                $_SESSION['userName'] = $foundUser['username'];

                $_SESSION['userRole'] = $foundUser['role'];
        
                $_SESSION['welcomeMessage'] = "Welcome back, $_SESSION[userName] !";
        
                if($foundUser['role'] == 'admin') {

                    header('location: admin');
                    die();

                } else {

                    header('location: index.php');
                    die();

                }

            }


        }
       
    
    }


}


?>


<div id="login">
    <?php include './template/errors.php'; ?>
    <h4>Welcome back!</h4>
    <h5 class="text-info">Please fill in the form below to login</h5>
    <hr>
    <form method="POST">


        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" value="<?php echo $userEmail;?>">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Your Password" class="form-control">
        </div>

        <div class="form-group">
            <button class="btn btn-success">Login!</button>
            <a href="passwordReset.php">Forgot your password?</a>
        </div>

    </form>

</div>


<?php require_once './template/footer.php'; ?>
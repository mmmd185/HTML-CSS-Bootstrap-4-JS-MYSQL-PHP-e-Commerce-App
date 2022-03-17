<?php 
$title = 'Create Users';
include __DIR__.'/../header.php';


$errors = [];
$username = '';
$userEmail = '';
$role = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = mysqli_real_escape_string($mySqli, $_POST['username']);
    $userEmail = mysqli_real_escape_string($mySqli, $_POST['email']);
    $userPassword = mysqli_real_escape_string($mySqli, $_POST['password']);
    $role = mysqli_real_escape_string($mySqli, $_POST['role']);


    if(empty($username)) {array_push($errors, 'Username is Required');}
    if(empty($userEmail)) {array_push($errors, 'Email is Required');}
    if(empty($userPassword)) {array_push($errors, 'Password is Required');}
    if(empty($role)) {array_push($errors, 'Role is Required');}



    if(!count($errors)) {


        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        $newUserQuery = "INSERT INTO users (username, user_password, email, role) VALUES ('$username', '$userPassword', '$userEmail', '$role')";

        $mySqli->query($newUserQuery);

        if($mySqli->error) {

            array_push($errors, $mySqli->error);

        } else {

            echo "<script>window.location.href='index.php'</script>";

        }
    
        
    }

}
?>


<div class="card">

    <div class="content">
        
        <?php include '../errors.php'; ?>

        <form method="POST">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Your Username" class="form-control"  value="<?php echo $username?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" value="<?php echo $userEmail?>">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Your Password" class="form-control" >
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="user" <?php if($role == 'user') echo 'selected';?>>User</option>
                    <option value="admin" <?php if($role == 'admin') echo 'selected';?>>Admin</option>
                </select>
            </div>
            

            <div class="form-group">
                <button class="btn btn-success">Create!</button>
            </div>

        </form>

    </div>

</div>






<?php include __DIR__.'/../footer.php';?>
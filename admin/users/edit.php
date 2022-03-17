<?php 
$title = 'Edit Users';
include __DIR__.'/../header.php';

if(!isset($_GET['id']) || !$_GET['id']) {

    die('Missing id parameter');

} 

$st = $mySqli->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$st->bind_param("i", $userId);
$userId = $_GET['id'];
$st->Execute();
$user = $st->get_result()->fetch_assoc();


$username = $user['username'];
$userEmail = $user['email'];
$role = $user['role'];
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST['username'])) {array_push($errors, 'Username is Required');}
    if(empty($_POST['email'])) {array_push($errors, 'Email is Required');}
    if(empty($_POST['role'])) {array_push($errors, 'Role is Required');}


    if(!count($errors)) {

        $st = $mySqli->prepare("UPDATE users SET username = ?, email = ?, user_password = ?, role = ? WHERE id = ?");
        $st->bind_param('ssssi', $dbName, $dbEmail, $dbPass, $dbRole, $dbId);
        
        $dbName = $_POST['username'];
        $dbEmail = $_POST['email'];
        $dbRole = $_POST['role'];
        $dbId = $_GET['id'];
        $_POST['password'] ? $dbPass = password_hash($_POST['password'], PASSWORD_DEFAULT) : $dbPass = $user['user_password'];
        
        $st->execute();

        if($mySqli->error) {

            array_push($errors, $mySqli->error);

        } else {

            echo "<script>window.location.href = 'index.php'</script>";

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
                <button class="btn btn-success">Update!</button>
            </div>

        </form>

    </div>

</div>

<?php include __DIR__.'/../footer.php';?>
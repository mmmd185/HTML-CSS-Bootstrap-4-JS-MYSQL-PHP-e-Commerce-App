<?php 
$title = 'Edit Settings';
include __DIR__.'/../header.php';


$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST['appName'])) {array_push($errors, 'App Name is Required');}
    if(empty($_POST['adminEmail'])) {array_push($errors, 'Admin Email is Required');}


    if(!count($errors)) {

        $st = $mySqli->prepare("UPDATE settings SET app_name = ?, admin_email = ? WHERE id = 1");
        $st->bind_param('ss', $dbName, $dbEmail);
        
        $dbName = $_POST['appName'];
        $dbEmail = $_POST['adminEmail'];
            
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
                <label for="appName">App Name:</label>
                <input type="text" name="appName" id="appName" placeholder="App Name" class="form-control"  value="<?php echo $appInfo['appName']?>">
            </div>

            <div class="form-group">
                <label for="adminEmail">Price:</label>
                <input type="email" name="adminEmail" id="adminEmail" placeholder="Admin Email" class="form-control" value="<?php echo $appInfo['adminEmail']?>">
            </div>

            <div class="form-group">
                <button class="btn btn-success">Update!</button>
            </div>

        </form>

    </div>

</div>

<?php include __DIR__.'/../footer.php';?>
<?php 
$title = 'Edit Services';
include __DIR__.'/../header.php';

if(!isset($_GET['id']) || !$_GET['id']) {

    die('Missing id parameter');

} 

$st = $mySqli->prepare("SELECT * FROM services WHERE id = ? LIMIT 1");
$st->bind_param("i", $serviceId);
$serviceId = $_GET['id'];
$st->Execute();
$service = $st->get_result()->fetch_assoc();


$serviceName = $service['name'];
$servicePrice = $service['price'];
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST['serviceName'])) {array_push($errors, 'Service Name is Required');}
    if(empty($_POST['servicePrice'])) {array_push($errors, 'Service Price is Required');}


    if(!count($errors)) {

        $st = $mySqli->prepare("UPDATE services SET name = ?, price = ? WHERE id = ?");
        $st->bind_param('sdi', $dbName, $dbPrice, $dbId);
        
        $dbName = $_POST['serviceName'];
        $dbPrice = $_POST['servicePrice'];
        $dbId = $_GET['id'];
            
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
                <label for="serviceName">Name:</label>
                <input type="text" name="serviceName" id="serviceName" placeholder="Service Name" class="form-control"  value="<?php echo $serviceName?>">
            </div>

            <div class="form-group">
                <label for="servicePrice">Price:</label>
                <input type="text" name="servicePrice" id="servicePrice" placeholder="Service Price" class="form-control" value="<?php echo $servicePrice?>">
            </div>

            <div class="form-group">
                <button class="btn btn-success">Update!</button>
            </div>

        </form>

    </div>

</div>

<?php include __DIR__.'/../footer.php';?>
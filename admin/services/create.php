<?php 
$title = 'Create Services';
include __DIR__.'/../header.php';


$errors = [];
$serviceName = '';
$servicePrice = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $serviceName = mysqli_real_escape_string($mySqli, $_POST['serviceName']);
    $servicePrice = mysqli_real_escape_string($mySqli, $_POST['servicePrice']);

    if(empty($serviceName)) {array_push($errors, 'Service Name is Required');}
    if(empty($servicePrice)) {array_push($errors, 'Service Price is Required');}

    if(!count($errors)) {


        $newServiceQuery = "INSERT INTO services (name, price) VALUES ('$serviceName', '$servicePrice')";

        $mySqli->query($newServiceQuery);

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
                <label for="serviceName">Name:</label>
                <input type="text" name="serviceName" id="serviceName" placeholder="Service Name" class="form-control"  value="<?php echo $serviceName?>">
            </div>

            <div class="form-group">
                <label for="servicePrice">Price:</label>
                <input type="text" name="servicePrice" id="servicePrice" placeholder="Service Price" class="form-control" value="<?php echo $servicePrice?>">
            </div>
            

            <div class="form-group">
                <button class="btn btn-success">Create!</button>
            </div>

        </form>

    </div>

</div>






<?php include __DIR__.'/../footer.php';?>
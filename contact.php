<?php 
$title = "Contact Us";
require_once "template/header.php";
require_once "includes/uploader.php";
require "./classes/Service.php";

$s = new Service();
$s->taxRate = 0.15;

if ($s->available) {

$servicesTable = $mySqli->query('SELECT name, id, price FROM services order by name')->fetch_all(MYSQLI_ASSOC);

?>

<form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" value="<?php if(isset($_SESSION['contactForm']['name'])) {echo $_SESSION['contactForm']['name'];}?>">
        <span class="text-danger"><?php echo $nameError ?></span>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php if(isset($_SESSION['contactForm']['email'])) {echo $_SESSION['contactForm']['email'];}?>">
        <span class="text-danger"><?php echo $emailError ?></span>
    </div>

    <div class="form-group">
        <label for="document">File:</label>
        <input type="file" class="form-control" name="document">
        <span class="text-danger"><?php echo $documentError ?></span>
    </div>

    <div class="form-group">
        <label for="services">Select a Service:</label>
        <select name="services" id="services" class="form-control">
        
        <?php foreach($servicesTable as $service) {?>

            <option value="<?php echo $service['id'] ?>"> <?php echo $service['name'] . ' $' . $s->totalPrice($service['price']); ?></option>

        <?php } ?>

        </select>
    </div>

    <div class="form-group">
        <label for="message">Message:</label>
        <textarea name="message" class="form-control"><?php if(isset($_SESSION['contactForm']['message'])) {echo $_SESSION['contactForm']['message'];}?></textarea>
        <span class="text-danger"><?php echo $messageError ?></span>
    </div>
    <div class="form-group">
        <button class="btn btn-primary">Save</button>
    </div>


</form>
<?php
}
$mySqli->close();
 ?>
<?php require_once "template/footer.php";?>
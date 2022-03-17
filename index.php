<?php 
$title = "Home Page";
require_once "template/header.php";
require "./classes/Service.php";
//require "./classes/Product.php";
require "./config/app.php";
require_once "./config/db.php";

$serviceObj = new Service();
// $serviceObj->taxRate = .5;
//$productObj = new Product();
// $productObj->taxRate = .01;


if($serviceObj->available) { 
    
$productTable = $mySqli->query('SELECT * FROM products')->fetch_all(MYSQLI_ASSOC);    

?>

<div class='row'>

    <?php foreach($productTable as $product){ ?>


    <div class='col-md-4'>

        <div class='card mb-3'>
        
            <div class="custom-card-header" style="background-image: url('<?php echo $appInfo['appUrl'] .$product['image']?>')"></div>     

            <div class='card-body text-center'>
                
                <div class='card-title'><?php echo $product['name'] ?></div>

                <div><?php echo $product['description'] ?></div>

                <div>$ <?php echo $product['price'] ?></div>

                <hr>

            </div>
                        
        </div>
    
    </div>

    <?php } ?>

</div>

<?php
}
$mySqli->close();
?>

<?php require_once "template/footer.php";?>
<?php 
$title = 'Edit Products';
include __DIR__.'/../header.php';
require_once __DIR__.'/../../classes/uploads.php';

if(!isset($_GET['id']) || !$_GET['id']) {

    die('Missing id parameter');

} 

$st = $mySqli->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
$st->bind_param("i", $productId);
$productId = $_GET['id'];
$st->Execute();
$product = $st->get_result()->fetch_assoc();


$productName = $product['name'];
$productPrice = $product['price'];
$productDescription = $product['description'];
$productImage = $product['image'];
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST['name'])) {array_push($errors, 'Product Name is Required');}
    if(empty($_POST['price'])) {array_push($errors, 'Product Price is Required');}
    if(empty($_POST['description'])) {array_push($errors, 'Product description is Required');}


    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $date = date('Ym');
        $upload = new Upload($date);
        $upload->file = $_FILES['image'];
        $errors = $upload->upload();


        if(!count($errors)) {

            unlink($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $productImage);
            $productImage = $upload->filePath;

        }



    }

    if(!count($errors)) {

        $st = $mySqli->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $st->bind_param('sdssi', $dbName, $dbPrice, $dbDesc, $dbImg, $dbId);
        
        $dbName = $_POST['name'];
        $dbPrice = $_POST['price'];
        $dbId = $_GET['id'];
        $dbImg = 'uploads/products/' . $productImage;
        $dbDesc = $_POST['description'];
            
        $st->execute();

        if($mySqli->error) {

            array_push($errors, $mySqli->error);

        } else {

            echo "<script>window.location.href = 'index.php'</script>";

        }

    }

}



?>

<form method="POST" enctype="multipart/form-data">

<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" placeholder="Product Name" class="form-control"  value="<?php echo $productName?>">
</div>

<div class="form-group">
    <label for="price">Price:</label>
    <input type="text" name="price" id="price" placeholder="Product Price" class="form-control" value="<?php echo $productPrice?>">
</div>

<div class="form-group">
    <label for="description">Description:</label>
    <input type="text" name="description" id="description" placeholder="Product Description" class="form-control" value="<?php echo $productDescription?>">
</div>

<div class="form-group">
    <label for="image">Image:</label>
    <img src="<?php echo $appInfo['appUrl'] . $productImage;?>" width="150">
    <input type="file" name="image" id="image" placeholder="Product Image" class="form-control">
</div>

<div class="form-group">
    <button class="btn btn-success">Update!</button>
</div>

</form>

</div>

</div>

<?php include __DIR__.'/../footer.php';?>
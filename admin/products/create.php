<?php 
$title = 'Create Products';
include __DIR__.'/../header.php';
require_once __DIR__.'/../../classes/uploads.php';

$errors = [];
$name = '';
$price = '';
$description = '';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = mysqli_real_escape_string($mySqli, $_POST['name']);
    $price = mysqli_real_escape_string($mySqli, $_POST['price']);
    $description = mysqli_real_escape_string($mySqli, $_POST['description']);

    if(empty($name)){array_push($errors, "Name is required");}
    if(empty($price)){array_push($errors, "Price is required");}
    if(empty($description)){array_push($errors, "Description is required");}
    if(empty($_FILES['image']['name'])){array_push($errors, "Image is required");}

    if(!count($errors)){

        $date = date('Ym');
        $upload = new Upload($date);
        $upload->file = $_FILES['image'];
        $errors = $upload->upload();

    }


    if(!count($errors)){

        $query = "insert into products (name, description, price, image) values ('$name', '$description', '$price', 'uploads/products/$upload->filePath')";
        $mySqli->query($query);

        if($mySqli->error){
            array_push($errors, $mySqli->error);
        }else{
            echo "<script>location.href = 'index.php'</script>";
        }


    }
}
?>


<div class="card">

    <div class="content">
        
        <?php include '../errors.php'; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Product Name" class="form-control"  value="<?php echo $name?>">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" placeholder="Product Price" class="form-control" value="<?php echo $price?>">
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" name="description" id="description" placeholder="Product Description" class="form-control" value="<?php echo $description?>">
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image" placeholder="Product Image" class="form-control">
            </div>

            <div class="form-group">
                <button class="btn btn-success">Create!</button>
            </div>

        </form>

    </div>

</div>






<?php include __DIR__.'/../footer.php';?>
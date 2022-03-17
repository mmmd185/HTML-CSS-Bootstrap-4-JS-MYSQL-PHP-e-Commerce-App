<?php 
$title = 'Products';
include __DIR__.'/../header.php';
require_once __DIR__.'/../../classes/uploads.php';
$products = $mySqli->query('SELECT * FROM products ORDER BY id')->fetch_all(MYSQLI_ASSOC);

//delete product
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $st = $mySqli->prepare("DELETE FROM products WHERE id = ?");
    $st->bind_param("i", $pId);
    $pId = $_POST['deleteProduct'];
    $st->execute();

    if ($_POST['image']) {

        unlink($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $_POST['image']);
        
    }

    echo "<script>window.location.href = 'index.php';</script>";
}
?>

<div class="card">

    <div class="content">
        
        <a href="create.php" class="btn btn-success">Create a new Product</a>

        <p class="header">Products: <?php echo count($products); ?></p>

        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="0">ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product) {?>

                        <tr>
                            <td><?php echo $product['id']?></td>
                            <td><?php echo $product['name']?></td>
                            <td><?php echo $product['description']?></td>
                            <td><?php echo $product['price']?></td>
                            <td><img src="<?php echo $appInfo['appUrl'] . $product['image']?>"  width="100" alt=""></td>
                            <td>
                                <a href="<?php echo "edit.php?id=$product[id]";?>" class="btn btn-warning">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" value="<?php echo $product['id'] ?>" name="deleteProduct">
                                    <input type="hidden" value="<?php echo $product['image'] ?>" name="image">
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>

        </div>


    </div>

</div>




<?php include __DIR__.'/../footer.php';?>
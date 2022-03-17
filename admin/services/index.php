<?php 
$title = 'Services';
include __DIR__.'/../header.php';
$services = $mySqli->query('SELECT * FROM services ORDER BY id')->fetch_all(MYSQLI_ASSOC);

//delete service
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $st = $mySqli->prepare("DELETE FROM services WHERE id = ?");
    $st->bind_param("i", $sId);
    $sId = $_POST['deleteService'];
    $st->execute();
    echo "<script>window.location.href = 'index.php';</script>";
}
?>

<div class="card">

    <div class="content">
        
        <a href="create.php" class="btn btn-success">Create a new Service</a>

        <p class="header">Services: <?php echo count($services); ?></p>

        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="0">ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($services as $service) {?>

                        <tr>
                            <td><?php echo $service['id']?></td>
                            <td><?php echo $service['name']?></td>
                            <td><?php echo $service['price']?></td>
                            <td>
                                <a href="<?php echo "edit.php?id=$service[id]";?>" class="btn btn-warning">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" value="<?php echo $service['id'] ?>" name="deleteService">
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
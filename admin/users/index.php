<?php 
$title = 'Users';
include __DIR__.'/../header.php';
$users = $mySqli->query('SELECT * FROM users ORDER BY id')->fetch_all(MYSQLI_ASSOC);

//delete user
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $st = $mySqli->prepare("DELETE FROM users WHERE id = ?");
    $st->bind_param("i", $uId);
    $uId = $_POST['deleteUser'];
    $st->execute();
    echo "<script>window.location.href = 'index.php';</script>";
}
?>

<div class="card">

    <div class="content">
        
        <a href="create.php" class="btn btn-success">Create a new user</a>

        <p class="header">Users: <?php echo count($users); ?></p>

        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="0">ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user) {?>

                        <tr>
                            <td><?php echo $user['id']?></td>
                            <td><?php echo $user['username']?></td>
                            <td><?php echo $user['email']?></td>
                            <td><?php echo $user['role']?></td>
                            <td>
                                <a href="<?php echo "edit.php?id=$user[id]";?>" class="btn btn-warning">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" value="<?php echo $user['id'] ?>" name="deleteUser">
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
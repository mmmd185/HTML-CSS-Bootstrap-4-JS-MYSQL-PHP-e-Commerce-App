<?php
$title = 'Messages';
require_once './template/header.php';
require_once './config/db.php';
require_once './config/app.php';
require_once './includes/uploader.php';

$dbQuery = $mySqli->prepare("SELECT *, m.id as message_id, s.id as service_id, s.name as service_name FROM messages m LEFT JOIN services s on m.service_id = s.id order by m.id");

$dbQuery->execute();

$dbMessages = $dbQuery->get_result()->fetch_all(MYSQLI_ASSOC);


?>


<?php if(!isset($_GET['id'])){ ?>

    <h2>Received Messages</h2>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Document</th>
                    <th>Service</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach($dbMessages as $message) { ?>
                    
                    <tr>
                        <td><?php echo $message['message_id']; ?></td>
                        <td><?php echo $message['contact_name']; ?></td>
                        <td><?php echo $message['email']; ?></td>
                        <td><?php echo $message['document']; ?></td>
                        <td><?php echo $message['service_name']; ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="?id=<?php echo $message['message_id']?>">View</a>
                                <form method='POST' onsubmit="confirm('Are you sure?');" style="display: inline-block;">
                                     <button class="btn btn-sm btn-danger">Delete</button>
                                     <input type="hidden" name="message_id" value="<?php echo $message['message_id']; ?>">
                                </form>
                        </td>
                    </tr> 

                <?php } ?>

            </tbody>

        </table>

    </div>

<?php } else { 

$viewMessagesQuery = "SELECT *, s.name as service_name FROM messages m LEFT JOIN services s ON m.service_id = s.id WHERE m.id = " . $_GET['id'] .  " LIMIT 1" ;

$dbViewMessages = $mySqli->query($viewMessagesQuery)->fetch_array(MYSQLI_ASSOC);
     
?>

<div class="card">

    <h5 class="card-header">
        Message From: <?php echo $dbViewMessages['contact_name']; ?><br><br>
        <div class="small">
        Email: <?php echo $dbViewMessages['email']; ?>
        </div>

    </h5>

    <div class="card-body">
        Selected Service: <?php if($dbViewMessages['service_name']) {echo $dbViewMessages['service_name'];} else { echo 'No Service';} ?><br><br>
        <?php echo $dbViewMessages['message']; ?>
    </div>

    <?php if($dbViewMessages['document']){ ?>

        <div class="card-footer">

            <h5>File: <a target="__blank" href="<?php echo $appInfo['appUrl'] . $dbViewMessages['document'];?>">Download File</a></h5>



        </div>

    <?php } ?>

</div>

<?php  } 


if(isset($_POST['message_id'])) {


    $deleteQuery = $mySqli->prepare('DELETE FROM messages WHERE id = ?');
    $deleteQuery->bind_param("i", $messageId);
    $messageId = $_POST['message_id'];
    $deleteQuery->execute();



    header('location: messages.php');
    die();

}

?>

<?php $mySqli->close(); ?>

<?php require_once './template/footer.php';?>
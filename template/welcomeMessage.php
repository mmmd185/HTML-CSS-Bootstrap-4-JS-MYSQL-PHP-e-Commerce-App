<?php

if(isset($_SESSION['welcomeMessage'])) { ?>

<div class="alert alert-success">


    <?php echo $_SESSION['welcomeMessage'];
    
        unset($_SESSION['welcomeMessage']);
        
    ?>


</div>


<?php } 
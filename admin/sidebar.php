<div class="sidebar-wrapper">
    <div class="logo">
        <a href="<?php echo $appInfo['appUrl']?>" class="simple-text">
                <?php echo $appInfo['appName']?>
        </a>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $appInfo['appUrl']?>admin">
                <i class="nc-icon nc-chart-pie-35"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo $appInfo['appUrl']?>admin/users/index.php">
                <i class="nc-icon nc-circle-09"></i>
                <p>Users</p>
            </a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo $appInfo['appUrl']?>admin/services/index.php">
                <i class="nc-icon nc-notes"></i>
                <p>Services</p>
            </a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo $appInfo['appUrl']?>admin/products/index.php">
                <i class="nc-icon nc-paper-2"></i>
                <p>Products</p>
            </a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo $appInfo['appUrl']?>admin/settings/index.php">
                <i class="nc-icon nc-atom"></i>
                <p>Settings</p>
            </a>
        </li>
        
    </ul>
</div>
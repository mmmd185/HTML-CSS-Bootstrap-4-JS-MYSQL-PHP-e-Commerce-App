<?php

require_once 'db.php';

$settings = [];

$settings = $mySqli->query("SELECT * FROM settings")->fetch_assoc();


if($settings) {

    $appName = $settings['app_name'];
    $adminEmail = $settings['admin_email'];

} else {

    $appName = 'Service App';
    $adminEmail = 'admin@gmail.com';

}

$appInfo = [

    'lang' => 'en',
    'dir' => 'ltr',
    'appName' => $appName,
    'adminEmail' => $adminEmail,
    'appUrl' => 'http://127.0.0.1/',
    'adminAssets' => 'http://127.0.0.1/admin/'

];


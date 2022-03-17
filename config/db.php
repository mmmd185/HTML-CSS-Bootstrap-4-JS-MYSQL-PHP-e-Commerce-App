<?php





$dbConnection = [

    'host' => '127.0.0.1',
    'userName' => 'root',
    'password' => '',
    'dbName' => 'app'

];

$mySqli = new mysqli($dbConnection['host'], $dbConnection['userName'], $dbConnection['password'], $dbConnection['dbName']);


if($mySqli->connect_error) {

    die('Database connection Error ' . $mysqli->connect_error);

}
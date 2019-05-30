<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connection = mysqli_connect('localhost', 'zen', 'z3n');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'zenabis_test_db');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>
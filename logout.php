<?php
require('dbConnect.php');
session_start();
session_destroy();
mysqli_close($connection);
header('Location: index.php');
?>
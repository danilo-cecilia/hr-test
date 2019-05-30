<?php
//Start the Session
session_start();
if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    echo "Hi - " . $username . ", ";
    echo "<a href='logout.php'>Logout</a>";
}
else
{
    header('Location: index.php');
}

?>
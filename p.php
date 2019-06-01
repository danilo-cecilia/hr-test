<?php

session_start();
require('dbConnect.php');
mysqli_set_charset($connection,"utf8");

$psi_query = "SELECT * FROM `personalityscore` WHERE userid =".$_SESSION['userid'].";";
$psi_result = mysqli_query($connection, $psi_query);
$psi_row = mysqli_fetch_row($psi_result);

$answers = json_decode($psi_row[6]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Personality Test Results</title>
</head>
<body>
    <table>
        <tr>
            <?php
            foreach ($answers as $key => $value) {
                $col = substr($key, -1);

                if ($col == 4) {
                    printf("<td>". $key . "<td></tr>");
                } else {
                    printf("<td>" . $key . "<td>");
                }
            ?>
            <?php } ?>
    </table>    
</body>
</html>
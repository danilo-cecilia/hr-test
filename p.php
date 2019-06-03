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
            if (!isset($answers)) {
                echo("<td>No records found for Personality Test</td>");
            } else {
            foreach ($answers as $key => $value) {
                $col = substr($key, -1);

                if ($col == 4) {
                    printf("<td>". substr($key, 0, -3) . "</td>");
                    printf("<td>". $value. "</td></tr>");
                } else {
                    printf("<td>" . substr($key, 0, -3) . "</td>");
                    printf("<td>". $value. "</td>");
                }
            ?>
            <?php } ?>
    </table>
    <table>
        <thead>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
            <th>Column 4</th>
            <th>Grand Total</th>
        </thead>
        <tr>
            <td><?php echo($psi_row[2]); ?></td>
            <td><?php echo($psi_row[3]); ?></td>
            <td><?php echo($psi_row[4]); ?></td>
            <td><?php echo($psi_row[5]); ?></td>
            <td><?php echo($psi_row[2] + $psi_row[3] + $psi_row[4] + $psi_row[5]); ?></td>
        </tr>
    </table>
    <?php } ?>
</body>

</html>
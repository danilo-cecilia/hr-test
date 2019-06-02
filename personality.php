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

require('dbConnect.php');

mysqli_set_charset($connection,"utf8");
$psi_query = "SELECT * FROM `personalityqa` ";
$psi_result = mysqli_query($connection, $psi_query);
$psi_num_rows = mysqli_num_rows($psi_result);
$psi_rows = mysqli_fetch_all($psi_result, MYSQLI_ASSOC);

if (isset($_POST) and !empty($_POST)) {
    $results_json = json_encode($_POST);
    $column1 = 0;
    $column2 = 0;
    $column3 = 0;
    $column4 = 0;

    foreach ($_POST as $key => $value) {
        $col = substr($key, -1);

        switch ($col) {
            case 1:
                $column1 += $value;
                break;
            case 2:
                $column2 += $value;
                break;
            case 3:
                $column3 += $value;
                break;
            case 4:
                $column4 += $value;
                break;
            default:
                break;
        }

    }

    $save_data = "INSERT INTO personalityscore(userid, p1, p2, p3, p4, answers)
                  VALUES (".$_SESSION["userid"].",".$column1.", ".$column2.", ".$column3.", ".$column4.", '".mysqli_real_escape_string($connection, $results_json)."')";

    if ($connection->query($save_data) === TRUE) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $save_data . "<br>" . $connection->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/assessment3.css" />

    <title>Personal Style Indicator</title>
</head>

<body>
    <?php include 'header.php';?>

    <div class="container content">
        <h2 class="card-title">Personal Style Indicator</h2>
    </div>

    <div class="container content">
        <?php
        for ($i=0; $i < $psi_num_rows; $i++) {
            $psi_q1 = explode(',', $psi_rows[$i]['p1']);
            $psi_q2 = explode(',', $psi_rows[$i]['p2']);
            $psi_q3 = explode(',', $psi_rows[$i]['p3']);
            $psi_q4 = explode(',', $psi_rows[$i]['p4']);
        ?>
        <form method="post">
            <div class="row">
                <div class="col-3 quality">
                    <div class="row">
                        <div class="col-8">
                            <p>
                                <?php echo($i+1)."."; ?>
                                <?php printf($psi_q1[0]); ?>
                            </p>
                            <p class="words"><?php printf($psi_q1[1]); ?></p>
                            <p class="words"><?php printf($psi_q1[2]); ?></p>
                            <p class="words"><?php printf($psi_q1[3]); ?></p>
                        </div>
                        <div class="col-4">
                            <select name="<?php printf($psi_q1[0]); ?>_c1" id="q_<?php printf($i+1); ?>_c1"
                                class="form-control">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3 quality">
                    <div class="row">
                        <div class="col-8">
                            <p><?php printf($psi_q2[0]); ?></p>
                            <p class="words"><?php printf($psi_q2[1]); ?></p>
                            <p class="words"><?php printf($psi_q2[2]); ?></p>
                            <p class="words"><?php printf($psi_q2[3]); ?></p>
                        </div>
                        <div class="col-4">
                            <select name="<?php printf($psi_q2[0]); ?>_c2" id="q_<?php printf($i+1); ?>_c2"
                                class="form-control">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3 quality">
                    <div class="row">
                        <div class="col-8">
                            <p><?php printf($psi_q3[0]); ?></p>
                            <p class="words"><?php printf($psi_q3[1]); ?></p>
                            <p class="words"><?php printf($psi_q3[2]); ?></p>
                            <p class="words"><?php printf($psi_q3[3]); ?></p>
                        </div>
                        <div class="col-4">
                            <select name="<?php printf($psi_q3[0]); ?>_c3" id="q_<?php printf($i+1); ?>_c3"
                                class="form-control">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3 quality">
                    <div class="row">
                        <div class="col-8">
                            <p><?php printf($psi_q4[0]); ?></p>
                            <p class="words"><?php printf($psi_q4[1]); ?></p>
                            <p class="words"><?php printf($psi_q4[2]); ?></p>
                            <p class="words"><?php printf($psi_q4[3]); ?></p>
                        </div>
                        <div class="col-4">
                            <select name="<?php printf($psi_q4[0]); ?>_c4" id="q_<?php printf($i+1); ?>_c4"
                                class="form-control">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <input type="submit" class="c__button" value="SUBMIT" />
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
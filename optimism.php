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
$optimism_query = "SELECT * FROM `optimismqa` ";
$optimism_result = mysqli_query($connection, $optimism_query);
$optimism_num_rows = mysqli_num_rows($optimism_result);
$optimism_rows = mysqli_fetch_all($optimism_result, MYSQLI_ASSOC);

if (isset($_POST) and !empty($_POST)) {
    $results_json = json_encode($_POST);

    $save_data = "INSERT INTO optimismscore(userid, answers)
                  VALUES (".$_SESSION["userid"].", '".mysqli_real_escape_string($connection, $results_json)."')";

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Learned Optimism</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/assessment2.css" />
</head>

<body>
    <?php include 'header.php';?>

    <div class="container content">
        <h2 class="card-title">Learned Optimism Test</h2>
    </div>

    <div class="container content">
        <?php
            for ($i=0; $i < $optimism_num_rows; $i+=2) {
        ?>
        <form method="post">
            <div class="row">
                <div class="col-6 quality">
                    <div>
                        <?php echo $optimism_rows[$i]['tid'].".";?>
                        <?php printf($optimism_rows[$i]['question']); ?>
                    </div>
                    <input type="hidden" id="question_<?php echo $optimism_rows[$i]['tid'];?>"
                        name="question[<?php echo $optimism_rows[$i]['tid'];?>]"
                        value="<?php echo $i+1;echo '. '.$optimism_rows[$i]['question'];?>">
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="answer[<?php printf($optimism_rows[$i]['tid']); ?>]"
                            id="radio<?php printf($optimism_rows[$i]['tid']); ?>"
                            value="op1_<?php printf($optimism_rows[$i]['option1']); ?>">
                        <label class="form-check-label" for="radio<?php printf($optimism_rows[$i]['tid']); ?>">
                            <?php printf($optimism_rows[$i]['option1']); ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="answer[<?php printf($optimism_rows[$i]['tid']); ?>]"
                            id="radio<?php printf($optimism_rows[$i]['tid']); ?>"
                            value="op2_<?php printf($optimism_rows[$i]['option2']); ?>">
                        <label class="form-check-label" for="radio<?php printf($optimism_rows[$i]['tid']); ?>">
                            <?php printf($optimism_rows[$i]['option2']); ?>
                        </label>
                    </div>
                </div>
                <div class="col-6 quality">
                    <div>
                        <?php echo $optimism_rows[$i+1]['tid'].".";?>
                        <?php printf($optimism_rows[$i+1]['question']); ?>
                    </div>
                    <input type="hidden" id="question_<?php echo $optimism_rows[$i+1]['tid'];?>"
                        name="question[<?php echo $optimism_rows[$i+1]['tid'];?>]"
                        value="<?php echo $i+2;echo '. '.$optimism_rows[$i+1]['question'];?>">
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="answer[<?php printf($optimism_rows[$i+1]['tid']); ?>]"
                            id="radio<?php printf($optimism_rows[$i+1]['tid']); ?>"
                            value="op1_<?php printf($optimism_rows[$i+1]['option1']); ?>">
                        <label class="form-check-label" for="radio<?php printf($optimism_rows[$i+1]['tid']); ?>">
                            <?php printf($optimism_rows[$i+1]['option1']); ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="answer[<?php printf($optimism_rows[$i+1]['tid']); ?>]"
                            id="radio<?php printf($optimism_rows[$i+1]['tid']); ?>"
                            value="op2_<?php printf($optimism_rows[$i+1]['option2']); ?>">
                        <label class="form-check-label" for="radio<?php printf($optimism_rows[$i+1]['tid']); ?>">
                            <?php printf($optimism_rows[$i+1]['option2']); ?>
                        </label>
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
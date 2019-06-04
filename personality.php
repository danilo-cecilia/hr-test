<?php
//Start the Session
session_start();
if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    // echo "Hi - " . $username . ", ";
    // echo "<a href='logout.php'>Logout</a>";
}
else
{
    header('Location: index.php');
}

require('dbConnect.php');

$psi_query = "SELECT * FROM `personalityqa` ";
$psi_result = mysqli_query($connection, $psi_query);
$psi_num_rows = mysqli_num_rows($psi_result);
$psi_rows = mysqli_fetch_all($psi_result, MYSQLI_ASSOC);

$user_tests_query = "SELECT * FROM `user` WHERE userid =".$_SESSION['userid'].";";
$user_tests_result = mysqli_query($connection, $user_tests_query);
$user_tests_row = mysqli_fetch_row($user_tests_result);

$user_tests_valid = $user_tests_row[7] + $user_tests_row[8] + $user_tests_row[9];
if ($user_tests_valid == 0 && isset($_SESSION['userid'])) {
    header('Location: thanks.php');
}

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
        // update test taken status for the user
        $test_status = "UPDATE user SET personality='0' WHERE userid=".$_SESSION["userid"];
        if ($connection->query($test_status) === TRUE) {
            // echo "Record updated successfully";
            if ($user_tests_valid == 0 && isset($_SESSION['userid'])) {
                header('Location: sendEmail.php');
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error: " . $save_data . "<br>" . $connection->error;
    }
    
    if ($_POST['timer'] <= 0) {
        $complete_test_query = "UPDATE user SET optimism='0', bigfive='0' WHERE userid=".$_SESSION["userid"];

        if ($connection->query($complete_test_query) === TRUE) {
            // echo "Record updated successfully";
            header('Location: sendEmail.php');
        } else {
            echo "Error updating record: " . $connection->error;
        }
    }
    
    // Refresh the page on submit
    echo("<meta http-equiv='refresh' content='0'>");
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
    <script>
    var userId = "<?php echo($_SESSION['userid']); ?>";
    </script>

    <title>Personal Style Indicator</title>
</head>

<body>
    <?php $page_title = "Personality"; ?>
    <?php include 'header.php';?>

    <div class="container content-main">
        <h2 class="card-title">Personal Style Indicator</h2>
        <p class="card-text">
            <b><u>Note</u> - Please attempt all questions before submit. Once you will submit the test, you can not
                attempt it again.</b>
        </p>
        <h2 class="card-title">Instructions</h2>
        <p class="card-text">
            Example: Please rank-order each set of four red words, as shown in the example below. <b>Use each number
                only once in each row.</b>
        </p>
    </div>

    <?php
    if ($user_tests_row[7] == 0) {
    ?>
    <div class="container content">
        <h2>You have completed this test.</br>Please select another one from the drop down menu.</h2>
    </div>
    <?php } else { ?>

    <div class="container content">
        <!-- Example code starts here -->
        <p>Example:</p>
        <hr>
        <div class="row">
            <div class="col-3 quality">
                <div class="row">
                    <div class="col-8">
                        <p style="color:red;"><b>Artistic</b></p>
                    </div>
                    <div class="col-4">
                        <select name="example_1" id="example_1" class="form-control" disabled>
                            <option value="0"></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3" selected>3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-3 quality">
                <div class="row">
                    <div class="col-8">
                        <p style="color:red;"><b>Technical</b></p>
                        <p class="words">(Most like me)</p>
                    </div>
                    <div class="col-4">
                        <select name="example_2" id="example_2" class="form-control" disabled>
                            <option value="0"></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4" selected>4</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-3 quality">
                <div class="row">
                    <div class="col-8">
                        <p style="color:red;"><b>Productive</b></p>
                        <p class="words">(Least like me)</p>
                    </div>
                    <div class="col-4">
                        <select name="example_3" id="example_3" class="form-control" disabled>
                            <option value="0"></option>
                            <option value="1" selected>1</option>
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
                        <p style="color:red;"><b>Supportive</b></p>
                    </div>
                    <div class="col-4">
                        <select name="example_4" id="example_4" class="form-control" disabled>
                            <option value="0"></option>
                            <option value="1">1</option>
                            <option value="2" selected>2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- Example code ends here -->

        <?php
        for ($i=0; $i < $psi_num_rows; $i++) {
            $psi_q1 = explode(',', $psi_rows[$i]['p1']);
            $psi_q2 = explode(',', $psi_rows[$i]['p2']);
            $psi_q3 = explode(',', $psi_rows[$i]['p3']);
            $psi_q4 = explode(',', $psi_rows[$i]['p4']);
        ?>
        <form id="testForm" method="post">
            <div class="row q_<?php printf($i+1); ?>">
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
                                class="form-control dropdown">
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
                                class="form-control dropdown">
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
                                class="form-control dropdown">
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
                                class="form-control dropdown">
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
                <input type="hidden" id="timer" name="timer" value="">
                <input type="submit" class="c__button" value="SUBMIT" />
            </div>
        </form>
    </div>

    <?php } ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    $(document).ready(function() {
        $("select").change(function(e) {
            var optionArray = ["1", "2", "3", "4"];

            id = $(this).attr('id');

            column = id.substring(0, id.length - 1);
            for (let i = 1; i < 5; i++) {
                col = "#" + column + i;
                existing_value = $(col).children("option:selected").val();
                var index = optionArray.indexOf(existing_value);
                if (index > -1) {
                    optionArray.splice(index, 1);
                }
            }
            for (let i = 1; i < 5; i++) {
                col = "#" + column + i;

                existing_value = $(col).children("option:selected").val();
                $(col).find('option').remove().end();
                if (existing_value > 0) {
                    $(col).append('<option>' + existing_value + '</option>').val(existing_value);
                    $(col).append('<option></option>');

                } else {
                    $(col).append('<option></option>').val('');
                }
                optionArray.forEach(function(value) {
                    $(col).append('<option>' + value + '</option>');
                });
            }
        });
    });
    </script>
</body>

</html>
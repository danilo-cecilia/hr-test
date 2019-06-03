<?php

//Start the Session
session_start();
if (isset($_SESSION['username'])){
  $username = $_SESSION['username'];
//   echo "Hi - " . $username . ", ";
//   echo "<a href='logout.php'>Logout</a>";
}
else
{
  header('Location: index.php');
}

require('dbConnect.php');

$optimism_query = "SELECT * FROM `optimismqa` ";
$optimism_result = mysqli_query($connection, $optimism_query);
$optimism_num_rows = mysqli_num_rows($optimism_result);
$optimism_rows = mysqli_fetch_all($optimism_result, MYSQLI_ASSOC);

$user_tests_query = "SELECT * FROM `user` WHERE userid =".$_SESSION['userid'].";";
$user_tests_result = mysqli_query($connection, $user_tests_query);
$user_tests_row = mysqli_fetch_row($user_tests_result);

$user_tests_valid = $user_tests_row[7] + $user_tests_row[8] + $user_tests_row[9];
if ($user_tests_valid == 0 && isset($_SESSION['userid'])) {
    header('Location: thanks.php');
}

if (isset($_POST) and !empty($_POST)) {
    $results_json = json_encode($_POST);

    $save_data = "INSERT INTO optimismscore(userid, answers)
                  VALUES (".$_SESSION["userid"].", '".mysqli_real_escape_string($connection, $results_json)."')";

    if ($connection->query($save_data) === TRUE) {
        $inactiveTestSql = "UPDATE user SET optimism='0' WHERE userid=".$_SESSION["userid"];

    if ($connection->query($inactiveTestSql) === TRUE) {
        // if all tests done send email to HR
        $checkTestsQuesry = "SELECT personality, bigfive, optimism FROM user WHERE userid = ".$_SESSION["userid"];
        $result = mysqli_query($connection, $checkTestsQuesry) or die(mysqli_error($connection));
        $testStatusArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if($testStatusArr[0]['personality'] == '0' && $testStatusArr[0]['bigfive'] == '0' && $testStatusArr[0]['optimism'] == '0')
        {
          $to = 'amrik.jabbal@zenabis.com';
          $subject = "Test Results for ".$_SESSION["first_name"]." ".$_SESSION["last_name"];
          $resultBody = '';
          $classCounnter = 0;
          for ($key=1; $key <=count($_POST['question']); $key+=2) 
          { 
            $classCounnter++;
            $rowStyle = "";
            if ($classCounnter%2 == 0) 
                $rowStyle = "style='background-color: #e0e0e0;'";
            
            $resultBody .= "<tr ".$rowStyle.">";
            if(isset($_POST['answer'][$key]) && $_POST['answer'][$key]!='')
                $resultBody .= "<th style='text-align: left;'>".$_POST['question'][$key]."</th><td style='text-align: center;margin-right:10px'>".substr($_POST['answer'][$key], 4)."</td>";
            else
                $resultBody .= "<th style='text-align: left;'>".$_POST['question'][$key]."</th><td style='text-align: center;margin-right:10px'>No answer selected</td>";

            if(isset($_POST['answer'][$key+1]) && $_POST['answer'][$key+1]!='')
                $resultBody .= "<th style='text-align: left;'>".$_POST['question'][$key+1]."</th><td style='text-align: center;margin-right:10px'>".substr($_POST['answer'][$key+1], 4)."</td>";
            else
                $resultBody .= "<th style='text-align: left;'>".$_POST['question'][$key+1]."</th><td style='text-align: center;margin-right:10px'>No answer selected</td>";
            $resultBody .= "</tr>";
          }
          
          $htmlContent = '
              <html>
              <head>
                  <title>Welcome to Zenabis Global Inc.</title>
              </head>
              <body>
                  <h3>Test Results for '.$_SESSION["first_name"].' '.$_SESSION["last_name"].'</h3>
                  <h3>Applied for the position of '.$_SESSION["position"].'</h3>
                  <h3>Applicant email id '.$_SESSION["email"].'</h3>

                  <table cellspacing="0" style="border: 2px dashed #FB4314; width: auto; height: 200px;">
                      <tr style="background-color: #e0e0e0;">
                          <th style="text-align: left;">Questions</th><td style="text-align: left;margin-right:10px">Answers</td>
                          <th style="text-align: left;">Questions</th><td style="text-align: left;margin-right:10px">Answers</td>
                      </tr>
                      '.$resultBody.'
                  </table>
              </body>
              </html>';

          // Set content-type header for sending HTML email
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

          // Additional headers
          $headers .= 'From: Amrik<amrik.zira@gmail.com>' . "\r\n";

          // Send email
          if(mail($to,$subject,$htmlContent,$headers))
          {
            header('Location: thanks.php');
          }
          else
          {
            $errorMsg = 'Email sending fail.';
            echo $errorMsg;
          }
        }
    } else {
        echo "Error updating test: " . $connection->error;
    }
    } else {
        echo "Error: " . $save_data . "<br>" . $connection->error;
    }
    // Refresh the page on submit
    echo("<meta http-equiv='refresh' content='0'>");
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
    <?php $page_title = "Optimism"; ?>
    <?php include 'header.php';?>

    <div class="container content">
        <h2 class="card-title">Learned Optimism Test</h2>
    </div>

    <?php
    if ($user_tests_row[9] == 0) {
    ?>
    <div class="container content">
        <h2>You have completed this test.</br>Please select another one from the drop down menu.</h2>
    </div>
    <?php } else { ?>

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

    <?php } ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
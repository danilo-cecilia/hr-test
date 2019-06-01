<?php  
//Start the Session
session_start();
if (isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  //echo "Hi - " . $username . ", ";
  //echo "<a href='logout.php'>Logout</a>";
}
else
{
  header('Location: login.php');
}
require('dbConnect.php');

if (isset($_POST) and !empty($_POST)){
  $resultsJSON = json_encode($_POST);
  
  $extroversion = 20 + $_POST['rating'][1] - $_POST['rating'][6] + $_POST['rating'][11] - $_POST['rating'][16] + $_POST['rating'][21] - $_POST['rating'][26] + $_POST['rating'][31] - $_POST['rating'][36] + $_POST['rating'][41] - $_POST['rating'][46];
  
  $agreeableness = 14 - $_POST['rating'][2] + $_POST['rating'][7] - $_POST['rating'][12] + $_POST['rating'][17] - $_POST['rating'][22] + $_POST['rating'][27] - $_POST['rating'][32] + $_POST['rating'][37] + $_POST['rating'][42] + $_POST['rating'][47];

  $conscientiousness = 14 + $_POST['rating'][3] - $_POST['rating'][8] + $_POST['rating'][13] - $_POST['rating'][18] + $_POST['rating'][23] - $_POST['rating'][28] + $_POST['rating'][33] - $_POST['rating'][38] + $_POST['rating'][43] + $_POST['rating'][48];

  $neuroticism = 38 - $_POST['rating'][4] + $_POST['rating'][9] - $_POST['rating'][14] + $_POST['rating'][19] - $_POST['rating'][24] - $_POST['rating'][29] - $_POST['rating'][34] - $_POST['rating'][39] - $_POST['rating'][44] - $_POST['rating'][49];

  $openness = 8 + $_POST['rating'][5] - $_POST['rating'][10] + $_POST['rating'][15] - $_POST['rating'][20] + $_POST['rating'][25] - $_POST['rating'][30] + $_POST['rating'][35] + $_POST['rating'][40] + $_POST['rating'][45] + $_POST['rating'][50];

 

  $resultSQL = "INSERT INTO bigfivescore(userid, extroversion, agreeableness, conscientiousness, neuroticism, openness, answers) VALUES (".$_SESSION["userid"].", $extroversion, $agreeableness, $conscientiousness, $neuroticism, $openness, '".mysqli_real_escape_string($connection, $resultsJSON)."')";

  if ($connection->query($resultSQL) === TRUE) {
    $inactiveTestSql = "UPDATE user SET bigfive='0' WHERE userid=".$_SESSION["userid"];

    if ($connection->query($inactiveTestSql) === TRUE) {
        // if all tests done send email to HR
        $checkTestsQuesry = "SELECT personality, bigfive, optimism FROM user WHERE userid = ".$_SESSION["userid"];
        $result = mysqli_query($connection, $checkTestsQuesry) or die(mysqli_error($connection));
        $testStatusArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //if($testStatusArr[0]['personality'] == '0' && $testStatusArr[0]['bigfive'] == '0' && $testStatusArr[0]['optimism'] == '0')
        //{
          $to = 'amrik.jabbal@zenabis.com';
          $subject = "Test Results for ".$_SESSION["first_name"]." ".$_SESSION["last_name"];
          $resultBody = '';
          
          foreach ($_POST['rating'] as $key => $value) {
            if($key<=25)
            {
              $resultBody .= "<tr>
                              <th style='text-align: left;'>".$_POST['question'][$key]."</th><td style='text-align: center;margin-right:10px'>".$value."</td>
                              <th style='text-align: left;'>".$_POST['question'][$key+25]."</th><td style='text-align: center;margin-right:10px'>".$_POST['rating'][$key+25]."</td>
                          </tr>";
            }
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
                  <span><u>Calculated Results - </u></span>

                  <table cellspacing="0" style="width: auto; height: 100px;">
                    <tr>
                        <td style="text-align: left;">Extroversion (E) - '.$extroversion.'</td><td style="text-align: right;margin-right:10px">Neuroticism (N) - '.$neuroticism.'</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Agreeableness (E) - '.$agreeableness.'</td><td style="text-align: right;margin-right:10px">Conscientiousness (C) - '.$conscientiousness.'</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Openness to Experience (O) - '.$openness.'</td><td style="text-align: right;margin-right:10px"></td>
                    </tr>
                  </table>

                  <table cellspacing="0" style="border: 2px dashed #FB4314; width: auto; height: 200px;">
                      <tr style="background-color: #e0e0e0;">
                          <th style="text-align: left;">Questions</th><td style="text-align: right;margin-right:10px">Answers</td>
                          <th style="text-align: left;">Questions</th><td style="text-align: right;margin-right:10px">Answers</td>
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
            $successMsg = 'Email has sent successfully.';
          }
          else
          {
            $errorMsg = 'Email sending fail.';
            echo $errorMsg;
          }
        //}
    } else {
        echo "Error updating test: " . $connection->error;
    }
  } else {
      echo "Error: " . $resultSQL . "<br>" . $connection->error;
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
  <link rel="stylesheet" href="css/assessment1.css" />

  <title>Assessment Personality Test</title>
</head>

<body>
<?php include 'header.php';?>

  <div class="container content">
  <form method="POST">
    <h2 class="card-title">Introduction to The Big Five Personality Test</h2>
    <p class="card-text">
      This is a personality test, it will help you understand why you act the
      way that you do and how your personality is structured. Please follow
      the instructions below, scoring and results are on the next page.
    </p>

    <h2 class="card-title">Instructions</h2>
    <p class="card-text">
      In the table below, for each statement 1-50 mark how much you agree with
      on the scale 1-5, where 1=disagree, 2=slightly disagree, 3=neutral,
      4=slightly agree and 5=agree, in the box to the left of it.
    </p>

    <div class="row">
      <div class="col-sm">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col">Rating</th>
                    <th scope="col">I...</th>
                    <th scope="col">Rating</th>
                    <th scope="col">I...</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $bigFiveQuery = "SELECT * FROM `bigfiveqa`";
                $bigFiveResult = mysqli_query($connection, $bigFiveQuery) or die(mysqli_error($connection));
                $bigFiveRows = mysqli_fetch_all($bigFiveResult, MYSQLI_ASSOC);

                for ($i=0, $k=25; $i<count($bigFiveRows)/2; $i++, $k++) {
                ?>
                    <tr>
                        <td class="rating">
                            <select class="form-control" name="rating[<?php echo $bigFiveRows[$i]['tid'];?>]">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>

                        <td><span><?php echo $i+1;echo '. '.$bigFiveRows[$i]['question'];?></span></td>
                        <input type="hidden" id="question_<?php echo $bigFiveRows[$i]['tid'];?>" name="question[<?php echo $bigFiveRows[$i]['tid'];?>]" value="<?php echo $i+1;echo '. '.$bigFiveRows[$i]['question'];?>">
                        <td class="rating">
                            <select class="form-control" name="rating[<?php echo $bigFiveRows[$k]['tid'];?>]">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                        <td><?php echo $k+1;echo '. '.$bigFiveRows[$k]['question'];?></td>
                        <input type="hidden" id="question_<?php echo $bigFiveRows[$k]['tid'];?>" name="question[<?php echo $bigFiveRows[$k]['tid'];?>]" value="<?php echo $k+1;echo '. '.$bigFiveRows[$k]['question'];?>">
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <input type="submit" class="c__button" value="SUBMIT" />
      </div>
    </div>
    </form>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
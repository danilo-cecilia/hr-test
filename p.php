<?php

session_start();
require('dbConnect.php');
mysqli_set_charset($connection,"utf8");

$psi_query = "SELECT * FROM `personalityscore` WHERE userid =".$_SESSION['userid'].";";
$psi_result = mysqli_query($connection, $psi_query);
$psi_row = mysqli_fetch_row($psi_result);

$answers = json_decode($psi_row[6]);

$optimism_query = "SELECT * FROM `optimismscore` WHERE userid =".$_SESSION['userid'].";";
$optimism_result = mysqli_query($connection, $optimism_query);
$optimism_row = mysqli_fetch_row($optimism_result);

$optimism_answers = json_decode($optimism_row[2]);

$bigFive_query = "SELECT * FROM `bigfivescore` WHERE userid =".$_SESSION['userid'].";";
$bigFive_result = mysqli_query($connection, $bigFive_query);
$bigFive_row = mysqli_fetch_row($bigFive_result);

$bigFive_answers = json_decode($bigFive_row[7]);

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
    <div id="personality">
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
    </div>
    <?php } ?>

    <div id="optimism">
        <?php
        $to = 'amrik.jabbal@zenabis.com';
        $subject = "Test Results for ".$_SESSION["first_name"]." ".$_SESSION["last_name"];
        $resultBody = '';
        $classCounnter = 0;
        $optimism_answers =  json_decode(json_encode($optimism_answers), true);
        /*
        for ($key=1; $key <=count($optimism_answers['question']); $key+=2) 
        { 
            $classCounnter++;
            $rowStyle = "";
            if ($classCounnter%2 == 0) 
                $rowStyle = "style='background-color: #e0e0e0;'";
            
            $resultBody .= "<tr ".$rowStyle.">";
            if(isset($optimism_answers['answer'][$key]) && $optimism_answers['answer'][$key]!='')
                $resultBody .= "<th style='text-align: left;'>".$optimism_answers['question'][$key]."</th><td style='text-align: center;margin-right:10px'>".substr($optimism_answers['answer'][$key], 4)."</td>";
            else
                $resultBody .= "<th style='text-align: left;'>".$optimism_answers['question'][$key]."</th><td style='text-align: center;margin-right:10px'>No answer selected</td>";

            if(isset($optimism_answers['answer'][$key+1]) && $optimism_answers['answer'][$key+1]!='')
                $resultBody .= "<th style='text-align: left;'>".$optimism_answers['question'][$key+1]."</th><td style='text-align: center;margin-right:10px'>".substr($optimism_answers['answer'][$key+1], 4)."</td>";
            else
                $resultBody .= "<th style='text-align: left;'>".$optimism_answers['question'][$key+1]."</th><td style='text-align: center;margin-right:10px'>No answer selected</td>";
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
        */
    ?>
    </div>

    <div id="bigFive">
        <?php
        $to = 'amrik.jabbal@zenabis.com';
        $subject = "Test Results for ".$_SESSION["first_name"]." ".$_SESSION["last_name"];
        $resultBody = '';
        $bigFive_answers =  json_decode(json_encode($bigFive_answers), true);
        
        /*foreach ($bigFive_answers['rating'] as $key => $value) {
            if($key<=25)
            {
                $resultBody .= "<tr>
                                <th style='text-align: left;'>".$bigFive_answers['question'][$key]."</th><td style='text-align: center;margin-right:10px'>".$value."</td>
                                <th style='text-align: left;'>".$bigFive_answers['question'][$key+25]."</th><td style='text-align: center;margin-right:10px'>".$bigFive_answers['rating'][$key+25]."</td>
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
                        <td style="text-align: left;">Extroversion (E) - '.$bigFive_row[2].'</td><td style="text-align: right;margin-right:10px">Neuroticism (N) - '.$bigFive_row[5].'</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Agreeableness (E) - '.$bigFive_row[3].'</td><td style="text-align: right;margin-right:10px">Conscientiousness (C) - '.$bigFive_row[4].'</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Openness to Experience (O) - '.$bigFive_row[6].'</td><td style="text-align: right;margin-right:10px"></td>
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
          */
    ?>
    </div>
</body>

</html>
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
        
        <?php
        $resultBodyPersonality = '';
        $htmlContentPersonality = '';
        if (!isset($answers)) {
            $resultBodyPersonality .= "<td>No records found for Personality Test</td>";
        } else {
            $resultBodyPersonality = "<tr>";
            $classCounnter = 0;
            foreach ($answers as $key => $value) {
                $col = substr($key, -1);
                $rowStyle = "";
                if ($classCounnter%2 == 0) 
                    $rowStyle = "style='background-color: #e0e0e0;'";
                if ($col == 4) {
                    $resultBodyPersonality .= "<td ".$rowStyle.">". substr($key, 0, -3) . "</td>";
                    $resultBodyPersonality .= "<td ".$rowStyle.">". $value. "</td></tr>";
                    $classCounnter++;
                } else {
                    $resultBodyPersonality .= "<td ".$rowStyle.">" . substr($key, 0, -3) . "</td>";
                    $resultBodyPersonality .= "<td ".$rowStyle.">". $value. "</td>";
                }
            }   
        } 
        $totalOfResults = $psi_row[2] + $psi_row[3] + $psi_row[4] + $psi_row[5];
        $htmlContentPersonality  .= "<h3>Personality test results</h3>
                                    <table cellspacing='0' style='border: 2px dashed #FB4314; width: 1000px; height: 200px;'>".$resultBodyPersonality."
                                        </table><br>
                                        Total of each column - 
                                        <table>                                 
                                            <tr style='background-color: #e0e0e0;'>
                                                <td>Column 1 - </td><td>".$psi_row[2]."</td>
                                                <td>Column 2 - </td><td>".$psi_row[3]."</td>
                                                <td>Column 3 - </td><td>".$psi_row[4]."</td>
                                                <td>Column 4 - </td><td>".$psi_row[5]."</td>
                                            </tr>  
                                            <tr style='background-color: #e0e0e0;'>
                                                <td>Grand Total - </td><td>".$totalOfResults."</td>
                                            </tr>
                                        </table>";
                                    
        ?>
    </div>
    <div id="optimism">
        
        <?php
        $resultBodyOptimism = '';
        $classCounnter = 0;
        $optimism_answers =  json_decode(json_encode($optimism_answers), true);
        
        for ($key=1; $key <=count($optimism_answers['question']); $key+=2) 
        { 
            $classCounnter++;
            $rowStyle = "";
            if ($classCounnter%2 == 0) 
                $rowStyle = "style='background-color: #e0e0e0;'";
            
            $resultBodyOptimism .= "<tr ".$rowStyle.">";
            if(isset($optimism_answers['answer'][$key]) && $optimism_answers['answer'][$key]!='')
                $resultBodyOptimism .= "<th style='text-align: left;'>".$optimism_answers['question'][$key]."</th><td style='text-align: center;margin-right:10px'>".substr($optimism_answers['answer'][$key], 4)."</td>";
            else
                $resultBodyOptimism .= "<th style='text-align: left;'>".$optimism_answers['question'][$key]."</th><td style='text-align: center;margin-right:10px'>No answer selected</td>";

            if(isset($optimism_answers['answer'][$key+1]) && $optimism_answers['answer'][$key+1]!='')
                $resultBodyOptimism .= "<th style='text-align: left;'>".$optimism_answers['question'][$key+1]."</th><td style='text-align: center;margin-right:10px'>".substr($optimism_answers['answer'][$key+1], 4)."</td>";
            else
                $resultBodyOptimism .= "<th style='text-align: left;'>".$optimism_answers['question'][$key+1]."</th><td style='text-align: center;margin-right:10px'>No answer selected</td>";
            $resultBodyOptimism .= "</tr>";
        }
        
        $htmlContentOptimism = '<h3>Optimism test results</h3>
            <table cellspacing="0" style="border: 2px dashed #FB4314; width: auto; height: 200px;">
                <tr style="background-color: #e0e0e0;">
                    <th style="text-align: left;">Questions</th><td style="text-align: left;margin-right:10px">Answers</td>
                    <th style="text-align: left;">Questions</th><td style="text-align: left;margin-right:10px">Answers</td>
                </tr>
                '.$resultBodyOptimism.'
            </table>';
        
    ?>
    </div>
    <div id="bigFive">
        
        <?php
        $resultBodyBigFive = '';
        $bigFive_answers =  json_decode(json_encode($bigFive_answers), true);
        
        foreach ($bigFive_answers['rating'] as $key => $value) {
            if($key<=25)
            {
                $resultBodyBigFive .= "<tr>
                                <th style='text-align: left;'>".$bigFive_answers['question'][$key]."</th><td style='text-align: center;margin-right:10px'>".$value."</td>
                                <th style='text-align: left;'>".$bigFive_answers['question'][$key+25]."</th><td style='text-align: center;margin-right:10px'>".$bigFive_answers['rating'][$key+25]."</td>
                            </tr>";
            }
        }
        $htmlContentBigFive = '<h3>Big Five test results</h3>
                <table cellspacing="0" style="width: auto; height: 100px;">
                <tr><span><u>Calculated Results - </u></span></tr>
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
                    '.$resultBodyBigFive.'
                </table>';
    ?>
    </div>

    <?php
    $to = 'amrik.jabbal@zenabis.com, martin.dufficy@zenabis.com';
    $subject = "Test Results for ".$_SESSION["first_name"]." ".$_SESSION["last_name"];
    $finalEmailBody = $htmlContentPersonality.$htmlContentBigFive.$htmlContentOptimism;

    // Set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers
    $headers .= 'From: HR Assessment<hr_zenabis@app.zenabis.com>' . "\r\n";

    // Send email
    if(mail($to,$subject,$finalEmailBody,$headers))
    {
        header('Location: thanks.php');
    }
    else
    {
      $errorMsg = 'Email sending fail.';
      echo $errorMsg;
    }
    
    ?>
</body>

</html>
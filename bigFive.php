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
  
  $resultSQL = "INSERT INTO bigfivescore(userid,answers) VALUES (".$_SESSION["userid"].", '".mysqli_real_escape_string($connection, $resultsJSON)."')";

  if ($connection->query($resultSQL) === TRUE) {
      // Send results in an email
  } else {
      echo "Error: " . $resultSQL . "<br>" . $connection->error;
  }
  die;
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
                            <select class="form-control" name="rating_<?php echo $bigFiveRows[$i]['tid'];?>">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>

                        <td><span><?php echo $i+1;echo '. '.$bigFiveRows[$i]['question'];?></span></td>
                        <input type="hidden" id="question_<?php echo $bigFiveRows[$i]['tid'];?>" name="question_<?php echo $bigFiveRows[$i]['tid'];?>" value="<?php echo $i+1;echo '. '.$bigFiveRows[$i]['question'];?>">
                        <td class="rating">
                            <select class="form-control" name="rating_<?php echo $bigFiveRows[$k]['tid'];?>">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                        <td><?php echo $k+1;echo '. '.$bigFiveRows[$k]['question'];?></td>
                        <input type="hidden" id="question_<?php echo $bigFiveRows[$k]['tid'];?>" name="question_<?php echo $bigFiveRows[$k]['tid'];?>" value="<?php echo $k+1;echo '. '.$bigFiveRows[$k]['question'];?>">
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
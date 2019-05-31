<?php

require('dbConnect.php');

$optimism_query = "SELECT * FROM`optimismqa` ";
$optimism_result = mysqli_query($connection, $optimism_query);
$optimism_rows = mysqli_num_rows($optimism_result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assessment 2</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/jquery.quiz.css">
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/assessment2.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" data-toggle="collapse" data-target="#MainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="MainNav">
                <a href="#" class="navbar-brand">Optimism Test </a>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Tests</a>
                        <div class="dropdown-menu">
                            <a href="bigFive.php" class="dropdown-item">Test 1</a>
                            <a href="personality.php" class="dropdown-item">Test 2</a>
                            <a href="optimism.php" class="dropdown-item">Test 3</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div id="quiz">
            <div id="quiz-header">
                <h1>Learned Optimism Test</h1>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                    </div>
                    <div class="col">
                        <div id="quiz-start-screen">
                            <p>
                                <a href="#" id="quiz-start-btn" class="c__button">Start</a>
                            </p>
                        </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.quiz.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
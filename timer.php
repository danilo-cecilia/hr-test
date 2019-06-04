<?php
function add($a,$b){
  $c=$a+$b;
  return $c;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script>
    function phpadd() {
        var phpadd = "<?php echo add(1,2);?>"; //call the php add function;
        alert(phpadd);
    }

    function startTimer(duration, display) {
        var timer = duration,
            minutes, seconds;
        setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                timer = duration;
                phpadd();
            }
        }, 1000);
    }
    </script>
</head>

<body>
    <button onclick='phpadd()'>add</button>
    <div>Registration closes in <span id="time">05:00</span> minutes!</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        var fiveMinutes = 60 * 0.1,
            display = document.querySelector('#time');
        startTimer(fiveMinutes, display);
    });
    </script>
</body>

</html>
<?php
function add($a,$b){
  $c=$a+$b;
  return $c;
}
?>

<script>
function phpadd() {
    var phpadd = "<?php echo add(1,2);?>"; //call the php add function;
    alert(phpadd);
}

var status = 0;
var time = 0;

function stop() {
    status = 0;


}

function reset() {
    status = 0;
    time = 0;
    document.getElementById("timerLabel").innerHTML = "00:00:00";
}

function timer() {
    if (status == 1) {
        setTimeout(function() {
            time++;
            var min = Math.floor(time / 100 / 60);
            var sec = Math.floor(time / 100);
            var mSec = time % 100;

            if (min < 10) {
                min = "0" + min;
            }

            if (sec >= 60) {
                sec = sec % 60;
            }

            if (sec < 10) {
                sec = "0" + sec;

            }

            document.getElementById("timerLabel").innerHTML = min + ":" + sec + ":" + mSec;
            timer();

        }, 10);
    }
}
</script>

<button onclick='phpadd()'>add</button>
<h1 id="timerLabel">00:00:00</h1>

<script>
    $(document).ready(function(){
        status=1;
        timer();
    });
    </script>
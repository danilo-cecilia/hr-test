$(document).ready(function () {

    function startTimer(display) {
        var timer = localStorage.getItem(userId + 'zenTest'),
            minutes, seconds;
        var interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;
            localStorage.setItem(userId + 'zenTest', --timer);
            $('input[name="timer"]').val(timer);

            if (timer < 0) {
                $("#testForm").submit();
                localStorage.setItem(userId + 'zenTest', 0);
                stopTimer(interval);
            }
        }, 1000);
    }

    function stopTimer(interval) {
        clearInterval(interval);
    }

    var fiveMinutes = 20 * 1,
        display = document.querySelector('#time');

    if (localStorage.getItem(userId + 'zenTest')) {
        localStorage.getItem(userId + 'zenTest');
        startTimer(display);
    } else {
        localStorage.setItem(userId + 'zenTest', fiveMinutes);
        startTimer(display);
    }

});
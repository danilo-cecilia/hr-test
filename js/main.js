$(document).ready(function () {

    function startTimer(display) {
        var timer = localStorage.getItem(userId + 'zenTest'),
            hours, minutes, seconds;
        var interval = setInterval(function () {
            hours = parseInt(timer / 3600);
            minutes = parseInt((timer - (hours * 3600)) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + ":" + minutes + ":" + seconds;
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

    var timeInMinutes = 60 * 60 * 1.5, // 90 minutes
        display = document.querySelector('#time');

    if (localStorage.getItem(userId + 'zenTest')) {
        localStorage.getItem(userId + 'zenTest');
        startTimer(display);
    } else {
        localStorage.setItem(userId + 'zenTest', timeInMinutes);
        startTimer(display);
    }

});
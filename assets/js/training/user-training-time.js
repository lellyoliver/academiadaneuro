jQuery(document).ready(function ($) {
    let timerGame;
    let timerAudio;
    let timerVideo;
    let timeGame = 0;
    let timeAudio = 0;
    let timeVideo = 0;
    let isGameRunning = false;
    let isAudioRunning = false;
    let isVideoRunning = false;

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    function startTimerGame() {
        timerGame = setInterval(function () {
            timeGame++;
            $('#cognitive_stimulation').val(timeGame);
            $('#count-time-cognitivo .elementor-heading-title').text(formatTime(timeGame));
            if (timeGame >= 600) {
                pauseTimer(timerGame);
                $('#start-game').text('Iniciar').css('background-color', '');
                $('#go').css('display', 'none');
                isGameRunning = false;
            }
        }, 1000);
    }

    function startTimerAudio() {
        timerAudio = setInterval(function () {
            timeAudio++;
            $('#neural_resonance').val(timeAudio);
            $('#count-time-neural .elementor-heading-title').text(formatTime(timeAudio));
            if (timeAudio >= 1200) {
                pauseTimer(timerAudio);
                $('#start-neural').text('Iniciar').css('background-color', '');
                document.getElementById('audioPlayer').pause();
                isAudioRunning = false;
            }
        }, 1000);
    }

    function startTimerVideo() {
        timerVideo = setInterval(function () {
            timeVideo++;
            $('#neural_breathing').val(timeVideo);
            $('#count-time-breathing .elementor-heading-title').text(formatTime(timeVideo));
            if (timeVideo >= 600) {
                pauseTimer(timerVideo);
                $('#start-breathing').text('Iniciar').css('background-color', '');
                document.getElementById('videoPlayer').pause();
                isVideoRunning = false;
            }
        }, 1000);
    }

    function pauseTimer(timer) {
        clearInterval(timer);
    }

    $('#start-game').on('click', function () {
        if (isGameRunning) {
            pauseTimer(timerGame);
            $(this).text('Iniciar');
            $('#go').css('display', 'none');
            $(this).css('background-color', '');
        } else {
            // Pause other timers
            if (isAudioRunning) {
                pauseTimer(timerAudio);
                $('#start-neural').text('Iniciar').css('background-color', '');
                isAudioRunning = false;
                document.getElementById('audioPlayer').pause();
            }
            if (isVideoRunning) {
                pauseTimer(timerVideo);
                $('#start-breathing').text('Iniciar').css('background-color', '');
                isVideoRunning = false;
                document.getElementById('videoPlayer').pause();
            }
            startTimerGame();
            $(this).text('Pausar');
            $('#go').css('display', 'block');
            $(this).css('background-color', 'rgb(249 80 80)');
        }
        isGameRunning = !isGameRunning;
    });

    $('#start-neural').on('click', function () {
        const audio = document.getElementById('audioPlayer');

        if (isAudioRunning) {
            pauseTimer(timerAudio);
            $(this).text('Iniciar');
            $(this).css('background-color', '');
            audio.pause();
        } else {
            // Pause other timers
            if (isGameRunning) {
                pauseTimer(timerGame);
                $('#start-game').text('Iniciar').css('background-color', '');
                isGameRunning = false;
            }
            if (isVideoRunning) {
                pauseTimer(timerVideo);
                $('#start-breathing').text('Iniciar').css('background-color', '');
                isVideoRunning = false;
                document.getElementById('videoPlayer').pause();
            }
            startTimerAudio();
            $(this).text('Pausar');
            $(this).css('background-color', 'rgb(249 80 80)');
            audio.play();
        }
        isAudioRunning = !isAudioRunning;
    });

    $('#start-breathing').on('click', function () {
        const video = document.getElementById('videoPlayer');

        if (isVideoRunning) {
            pauseTimer(timerVideo);
            $(this).text('Iniciar');
            $(this).css('background-color', '');
            video.pause();
        } else {
            // Pause other timers
            if (isGameRunning) {
                pauseTimer(timerGame);
                $('#start-game').text('Iniciar').css('background-color', '');
                isGameRunning = false;
            }
            if (isAudioRunning) {
                pauseTimer(timerAudio);
                $('#start-neural').text('Iniciar').css('background-color', '');
                isAudioRunning = false;
                document.getElementById('audioPlayer').pause();
            }
            startTimerVideo();
            $(this).text('Pausar');
            $(this).css('background-color', 'rgb(249 80 80)');
            video.play();
        }
        isVideoRunning = !isVideoRunning;
    });
});

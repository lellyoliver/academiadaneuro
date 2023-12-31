function saveTraining() {

    const dhEnter = document.getElementById('DH_enter');
    const dhExit = document.getElementById('DH_exit');
    const userID = document.getElementById('user_id');
    const postID = document.getElementById('post_id');
    const neuralResonance = document.getElementById('neuralResonance');
    const cognitiveStimulation = document.getElementById('cognitiveStimulation');
    const neuralBreathing = document.getElementById('neuralBreathing');
    const updateProgress = document.getElementById('updateProgress');

    const gameplayStatusText = document.getElementById('gameplay').innerText.trim();

    if (gameplayStatusText.toLowerCase() === 'pausar') {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Não é possível salvar o treinamento enquanto o jogo estiver pausado.',
            confirmButtonColor: '#d33',
        });
        return;
    }

    fetch('/wp-json/adn-plugin/v1/myTrainingProgress', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userID.value,
            post_id: postID.value,
            DH_enter: dhEnter.value,
            DH_exit: dhExit.value,
            neuralResonance: neuralResonance.value,
            cognitiveStimulation: cognitiveStimulation.value,
            neuralBreathing: neuralBreathing.value,
            updateProgress: updateProgress.value,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            loading.style.display = 'none';
            if (data.status === 'sucesso') {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Treinamento salvo com sucesso.',
                    confirmButtonColor: '#28a745',
                }).then(() => {
                });
            } else {
                loading.style.display = 'none';
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao salvar o treinamento: ' + data.mensagem,
                    confirmButtonColor: '#d33',
                });
            }
        })
        .catch((error) => {
            console.error('Erro ao salvar o treinamento:', error);
        });
}

const btnSave = document.getElementById('saveTraining');
if (btnSave) {
    btnSave.addEventListener('click', (event) => {
        event.preventDefault();
        loading.style.display = '';
        saveTraining();
    });
}


document.addEventListener('DOMContentLoaded', function () {
    cronometroExit('DH_exit');
});

function cronometroExit(id) {
    let segundos = 0;
    let cronometro;
    const dhPlayer = document.getElementById(id);
    cronometro = setInterval(function () {
        const horas = Math.floor(segundos / 3600);
        const minutos = Math.floor((segundos % 3600) / 60);
        const segundosRestantes = segundos % 60;

        const formatoHora = String(horas).padStart(2, '0');
        const formatoMinuto = String(minutos).padStart(2, '0');
        const formatoSegundo = String(segundosRestantes).padStart(2, '0');

        dhPlayer.value = formatoHora + ':' + formatoMinuto + ':' + formatoSegundo;
        segundos++;
    }, 1000);

    return cronometro;
}

function playerAudio() {
    const audioPlayer = document.getElementById('audioPlayer');

    let intervaloCronometro;

    audioPlayer.addEventListener('play', function () {
        intervaloCronometro = cronometroExit('neuralResonance');
    });

    audioPlayer.addEventListener('pause', function () {
        clearInterval(intervaloCronometro);
    });
}

playerAudio();

function playerVideo() {
    const videoPlayer = document.getElementById('videoPlayer');
    let intervaloCronometro;

    videoPlayer.addEventListener('play', function () {
        intervaloCronometro = cronometroExit('neuralBreathing');
    });

    videoPlayer.addEventListener('pause', function () {
        clearInterval(intervaloCronometro);
    });
}

playerVideo();

function playerGame() {
    const gamePlayer = document.getElementById('gameplay');
    let intervaloCronometro;
    let isCronometroAtivo = false;

    gamePlayer.addEventListener('click', function (event) {
        event.preventDefault();

        if (isCronometroAtivo) {
            clearInterval(intervaloCronometro);
            intervaloCronometro = null;
            gamePlayer.innerText = 'Iniciar';
        } else {

            if (gamePlayer.innerText === 'Iniciar') {
                window.open(gamePlayer.href, '_blank');
            }
            intervaloCronometro = cronometroExit('cognitiveStimulation');
            gamePlayer.innerText = 'Pausar';
        }
        isCronometroAtivo = !isCronometroAtivo;
    });
}

playerGame();


/**
 * View API LINKS
 */

function viewTraining() {
    const postID = document.getElementById('post_id').value;
    const audioPlayer = document.getElementById('audioPlayer');
    const videoPlayer__2 = document.getElementById('videoPlayer');
    const gameplay = document.getElementById('gameplay');
    const textTraining = document.getElementById('textTraining');

    fetch(`/wp-json/adn-plugin/v1/myTraining/view/${postID}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                textTraining.innerHTML = data.textTraining;
                audioPlayer.src = data.neuralResonance;
                videoPlayer__2.src = data.neuralBreathing;
                gameplay.href = data.cognitiveStimulation;
            } else {
                console.error('Nenhuma informação encontrada');
            }
        })
        .catch(error => console.error('Erro ao recuperar dados', error));
}


viewTraining();

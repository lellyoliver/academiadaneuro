document.addEventListener('DOMContentLoaded', function () {
    function saveTraining() {
        const userID = document.getElementById('user_id');
        const postID = document.getElementById('post_id');
        const neuralResonance = document.getElementById('neural_resonance');
        const cognitiveStimulation = document.getElementById('cognitive_stimulation');
        const neuralBreathing = document.getElementById('neural_breathing');

        fetch('/wp-json/adn-plugin/v1/myTraining', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                user_id: userID.value,
                post_id: postID.value,
                neural_resonance: neuralResonance.value,
                cognitive_stimulation: cognitiveStimulation.value,
                neural_breathing: neuralBreathing.value,
            }),
        })
        .then((response) => response.json())
        .then((data) => {
            Swal.fire({
                title: 'Sucesso!',
                text: 'Treinamento atualizado com sucesso!',
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        })
        .catch((error) => {
            console.error('Erro ao salvar o treinamento:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Erro ao atualizar o treinamento!',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });
    }

    // setInterval(saveTraining, 180000);

    document.getElementById('submit-training').addEventListener('click', function() {
        saveTraining();
    });
});

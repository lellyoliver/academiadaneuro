function createTraining() {
    const form = document.getElementById('form-create');
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(form);

            const sleepQuality = formData.getAll('sleepQuality');
            const mentalFatigue = formData.getAll('mentalFatigue');
            const perceptionMindBody = formData.getAll('perceptionMindBody');
            const controlofAnxiety = formData.getAll('controlofAnxiety');
            const emotionalControl = formData.getAll('emotionalControl');
            const stress = formData.getAll('stress');
            const bodyPain = formData.getAll('bodyPain');
            const headache = formData.getAll('headache');
            const stimuliAnxiety = formData.getAll('stimuliAnxiety');
            const thoughtsInvasive = formData.getAll('thoughtsInvasive');
            const mentalActivity = formData.getAll('mentalActivity')
            const creativity = formData.getAll('creativity');
            const learningAndMemory = formData.getAll('learningAndMemory');
            const focusAndAttention = formData.getAll('focusAndAttention');
            const concentration = formData.getAll('concentration');
            const userID = formData.get('user_id');

            fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/training', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    sleepQuality: sleepQuality,
                    mentalFatigue: mentalFatigue,
                    perceptionMindBody: perceptionMindBody,
                    controlofAnxiety: controlofAnxiety,
                    emotionalControl: emotionalControl,
                    stress: stress,
                    bodyPain: bodyPain,
                    headache: headache,
                    stimuliAnxiety: stimuliAnxiety,
                    thoughtsInvasive: thoughtsInvasive,
                    mentalActivity: mentalActivity,
                    creativity: creativity,
                    learningAndMemory: learningAndMemory,
                    focusAndAttention: focusAndAttention,
                    concentration: concentration,
                    user_id: userID,
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sucesso') {
                    } else {
                        alert('Erro ao gerar um treinamento: ' + data.mensagem);
                    }
                })
                .catch(error => {
                    console.error('Erro ao gerar um treinamento:', error);
                });
        });
    }

}

createTraining();


function createTraining() {
    const form = document.getElementById('form-create');
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            Swal.fire({
                title: 'Deseja criar o treinamento?',
                text: 'Você tem certeza que deseja criar este treinamento?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Criar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
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
                    const mentalActivity = formData.getAll('mentalActivity');
                    const creativity = formData.getAll('creativity');
                    const learningAndMemory = formData.getAll('learningAndMemory');
                    const focusAndAttention = formData.getAll('focusAndAttention');
                    const concentration = formData.getAll('concentration');
                    const userID = formData.get('user_id');

                    fetch('/wp-json/adn-plugin/v1/training', {
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
                                Swal.fire('Sucesso!', 'Treinamento criado com sucesso.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Erro!', 'Erro: ' + data.mensagem, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                        });
                }
            });
        });
    }
}

createTraining();

function createTrainingChoice() {
    const formChoices = document.getElementById('create-choice-form');
    if (formChoices) {
        formChoices.addEventListener('submit', (event) => {
            event.preventDefault();

            Swal.fire({
                title: 'Deseja criar o treinamento?',
                text: 'Você tem certeza que deseja criar este treinamento?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Criar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(formChoices);

                    const postIDs = formData.getAll('post_id[]'); // Use 'post_id[]' para pegar todos os valores em um array
                    const userID = formData.get('user_id');

                    fetch('/wp-json/adn-plugin/v1/trainingChoice', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            post_id: postIDs, // Envie como um array
                            user_id: userID,
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'sucesso') {
                                Swal.fire('Sucesso!', 'Treinamento criado com sucesso.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Erro!', 'Erro: ' + data.mensagem, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                        });
                }
            });
        });
    }
}
createTrainingChoice();

function choicesCard() {
    const questionContainers = document.querySelectorAll('.question-container');
    if (questionContainers) {
        const selectedQuestionsContainer = document.getElementById('selected-questions');
        let draggedElement = null;

        function handleDragStart(e) {
            draggedElement = this;
            e.dataTransfer.setData('text/post-id', this.getAttribute('data-post-id'));
            e.dataTransfer.setData('text/question-title', this.getAttribute('data-question-title'));
        }

        function handleDragOver(e) {
            e.preventDefault();
            selectedQuestionsContainer.style.border = '2px dashed #000';
        }

        function handleDragLeave(e) {
            e.preventDefault();
            selectedQuestionsContainer.style.border = '';
        }

        function handleDrop(e) {
            e.preventDefault();
            selectedQuestionsContainer.style.border = '';

            if (draggedElement) {
                const questionPostID = draggedElement.getAttribute('data-post-id');
                const questionTitle = draggedElement.getAttribute('data-question-title');
                const selectedQuestion = document.createElement('div');
                selectedQuestion.className = 'selected-question';

                const titleSpan = document.createElement('small');
                titleSpan.textContent = questionTitle;

                const categoryHidden = document.createElement('input');
                categoryHidden.type = 'hidden';
                categoryHidden.name = 'post_id[]';
                categoryHidden.value = questionPostID;

                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'ms-3 btn btn-sm btn-danger';
                deleteButton.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                deleteButton.addEventListener('click', () => {
                    selectedQuestionsContainer.removeChild(selectedQuestion);
                });

                selectedQuestion.appendChild(titleSpan);
                selectedQuestion.appendChild(categoryHidden);
                selectedQuestion.appendChild(deleteButton);

                selectedQuestionsContainer.appendChild(selectedQuestion);
                draggedElement = null;
            }
        }

        questionContainers.forEach(container => {
            container.addEventListener('dragstart', handleDragStart);

            // Adicione eventos de toque para dispositivos móveis
            container.addEventListener('touchstart', handleDragStart);
            container.addEventListener('touchmove', (e) => {
                // Impedir o comportamento padrão de toque, que pode interferir no arrastar e soltar
                e.preventDefault();
            });
            container.addEventListener('touchend', handleDrop);
        });
        if(selectedQuestionsContainer){
            selectedQuestionsContainer.addEventListener('dragover', handleDragOver);
            selectedQuestionsContainer.addEventListener('dragleave', handleDragLeave);
            selectedQuestionsContainer.addEventListener('drop', handleDrop);
        }
    }
}

choicesCard();
function createTraining() {
    const form = document.getElementById('form-create');
    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            loading.style.display = '';
            const selects = form.querySelectorAll('.form-select');
            let isValid = true;

            for (const select of selects) {
                if (select.value === '0') {
                    isValid = false;
                    break;
                }
            }

            if (!isValid) {
                loading.style.display = 'none';
                Swal.fire('Erro!', 'Por favor, selecione uma opção para todos os campos.', 'error');
                return;
            }

            const result = await Swal.fire({
                title: 'Deseja criar o treinamento?',
                text: 'Você tem certeza que deseja criar este treinamento?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00a9e7',
                cancelButtonColor: '#dc3545',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim, Criar!',
            });

            if (result.isConfirmed) {
                const formData = new FormData(form);

                try {
                    const response = await fetch('/wp-json/adn-plugin/v1/training', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(Object.fromEntries(formData))
                    });

                    const data = await response.json();
                    loading.style.display = 'none';
                    if (data.status === 'sucesso') {
                        Swal.fire('Sucesso!', 'Treinamento criado com sucesso.', 'success').then(() => {
                            window.location.href = "meus-treinamentos";
                        });
                    } else {
                        loading.style.display = 'none';
                        Swal.fire('Erro!', 'Erro: ' + data.mensagem, 'error');
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    loading.style.display = 'none';
                    Swal.fire('Erro!', 'Ocorreu um erro ao processar a solicitação.', 'error');
                }
            }
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
                confirmButtonColor: '#00a9e7',
                cancelButtonColor: '#dc3545',
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
                                    window.location.href = "dashboard";
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
        const selectedQuestionsContainer = document.getElementById('selected-question-id');
        let draggedElement = null;
        let lastClickTime = 0;

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
                const currentTime = new Date().getTime();
                const timeDiff = currentTime - lastClickTime;

                if (timeDiff <= 500) {
                    return;
                }
                
                lastClickTime = currentTime;
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
            container.addEventListener('touchstart', handleDragStart);
            container.addEventListener('touchmove', (e) => {
                e.preventDefault();
            });
            container.addEventListener('touchend', handleDrop);
        });
        
        if (selectedQuestionsContainer) {
            selectedQuestionsContainer.addEventListener('dragover', handleDragOver);
            selectedQuestionsContainer.addEventListener('dragleave', handleDragLeave);
            selectedQuestionsContainer.addEventListener('drop', handleDrop);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    choicesCard();
});


// function scrollTrainingForm() {
//     let choiceForm = document.getElementById('create-choice-form');
//     if (choiceForm) {
//         const initialPosition = choiceForm.offsetTop;

//         window.addEventListener('scroll', function () {
//             let scrollPosition = window.scrollY;
//             let screenWidth = window.innerWidth;

//             // Adicione a condição para verificar a largura da tela
//             if (scrollPosition > initialPosition && screenWidth > 600) {
//                 choiceForm.style.position = 'fixed';
//                 choiceForm.style.width = '38%';
//                 choiceForm.style.bottom = '0';
//             } else {
//                 choiceForm.style.position = '';
//                 choiceForm.style.width = '';
//                 choiceForm.style.bottom = '';
//             }
//         });
//     }
// }

// scrollTrainingForm();

function questionTraining() {
    const valid = document.getElementById('form-create');
    if(valid) {
        const questionDivs = document.querySelectorAll('.select-questions');
        const totalQuestions = questionDivs.length;
        let currentIndex = 0;

        function showQuestions(index) {
            questionDivs.forEach((div, i) => {
                if (i >= index && i < index + 3) {
                    div.classList.remove('display-none');
                } else {
                    div.classList.add('display-none');
                }
            });

            const generateButton = document.getElementById('create-training');
            const nextButton = document.getElementById('button-next');
            const prevButton = document.getElementById('button-previous');

            if (index + 3 >= totalQuestions) {
                generateButton.classList.remove('display-none');
                nextButton.classList.add('display-none');
            } else {
                generateButton.classList.add('display-none');
                nextButton.classList.remove('display-none');
            }

            if (index > 0) {
                prevButton.classList.remove('display-none');
            } else {
                prevButton.classList.add('display-none');
            }
        }

        function next() {
            currentIndex += 3;
            if (currentIndex >= totalQuestions) {
                currentIndex = totalQuestions - 3;
            }
            showQuestions(currentIndex);
        }

        function previous() {
            if (currentIndex >= 3) {
                currentIndex -= 3;
            }
            showQuestions(currentIndex);
        }

        showQuestions(currentIndex);

        const prevButton = document.getElementById('button-previous');
        const nextButton = document.getElementById('button-next');

        prevButton.addEventListener('click', previous);
        nextButton.addEventListener('click', next);
    }
}

questionTraining();
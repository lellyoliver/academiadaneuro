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

                    const postIDs = formData.getAll('post_id[]');
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
    const selectedQuestionsContainer = document.getElementById('selected-question-id');
    const selectedQuestions = [];

    function handleClick(e) {
        const clickedElement = e.currentTarget;
        const questionPostID = clickedElement.getAttribute('data-post-id');
        const questionTitle = clickedElement.getAttribute('data-question-title');

        const isSelected = selectedQuestions.some(question => question.postID === questionPostID);

        if (!isSelected) {
            const selectedQuestion = {
                postID: questionPostID,
                title: questionTitle
            };

            selectedQuestions.push(selectedQuestion);

            const selectedQuestionElement = document.createElement('div');
            selectedQuestionElement.className = 'selected-question';

            const titleSpan = document.createElement('small');
            titleSpan.textContent = questionTitle;

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'ms-3 btn btn-sm btn-danger-custom';
            deleteButton.innerHTML = `<i class="fa-solid fa-trash"></i>`;
            deleteButton.addEventListener('click', () => {
                selectedQuestionsContainer.removeChild(selectedQuestionElement);
                const index = selectedQuestions.findIndex(q => q.postID === questionPostID);
                if (index !== -1) {
                    selectedQuestions.splice(index, 1);
                }
            });

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'post_id[]';
            hiddenInput.value = questionPostID;

            selectedQuestionElement.appendChild(titleSpan);
            selectedQuestionElement.appendChild(deleteButton);
            selectedQuestionElement.appendChild(hiddenInput);

            selectedQuestionsContainer.appendChild(selectedQuestionElement);
        }
    }

    questionContainers.forEach(container => {
        container.addEventListener('click', handleClick);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    choicesCard();
});

document.addEventListener('DOMContentLoaded', function () {
    function saveTraining2() {
        const userID = document.getElementById('user_id');
        const fields = [
            'sleep-quality',
            'mental-fatigue',
            'perception-mind-body',
            'control-of-anxiety',
            'emotional-control',
            'stress',
            'body-pain',
            'headache',
            'external-stimulus-anxiety',
            'thoughts-invasive',
            'mental-activity',
            'concentration',
            'creativity',
            'focus-and-attention',
            'learning-and-memory'
        ];

        let data = {
            user_id: userID.value
        };

        let allFieldsFilled = true;

        fields.forEach(field => {
            let index = 0;
            while (true) {
                const element = document.getElementById(`${field}-${index}`);
                if (element) {
                    if (!element.value) {
                        allFieldsFilled = false;
                        element.classList.add('input-error'); // Adiciona uma classe para destacar o campo vazio
                    } else {
                        element.classList.remove('input-error'); // Remove a classe caso o campo seja preenchido
                    }
                    data[`${field}-${index}`] = element.value;
                    index++;
                } else {
                    break;
                }
            }
        });

        if (!allFieldsFilled) {
            Swal.fire({
                title: 'Campos incompletos!',
                text: 'Por favor, preencha todos os campos antes de salvar.',
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
            return; // Impede o envio do formulário
        }

        fetch('/wp-json/adn-plugin/v1/training', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Treinamento gerado!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/meus-treinamentos';
                    }
                });
            })
            .catch((error) => {
                console.error('Erro ao salvar o treinamento:', error);
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao gerar o treinamento!',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            });
    }

    document.getElementById('submit-new-training').addEventListener('click', function (e) {
        e.preventDefault();
        saveTraining2();
    });
});

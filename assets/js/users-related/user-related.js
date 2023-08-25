function createUser() {
    const form = document.getElementById('form-create');
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            const name = formData.get('name');
            const email = formData.get('email');
            const password = formData.get('password');
            const billing_data = formData.get('billing_data');
            const phone = formData.get('phone');
            const cep = formData.get('cep');
            const address = formData.get('address');
            const states = formData.get('states');
            const role = formData.get('role');
            const city = formData.get('city');
            const connectedUser = formData.get('connected_user');
            const description = formData.get('description');

            fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users-related', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    billing_data: billing_data,
                    phone: phone,
                    cep: cep,
                    city: city,
                    address: address,
                    states: states,
                    role: role,
                    connected_user: connectedUser,
                    description: description,
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sucesso') {
                        location.reload()
                    } else {
                        alert('Erro ao atualizar usuário: ' + data.mensagem);
                    }
                })
                .catch(error => {
                    console.error('Erro ao atualizar usuário:', error);
                });
        });
    }

}

function updateUser() {
    const formUpdate = document.getElementById('form-update');

    formUpdate.addEventListener('submit', (event) => {
        event.preventDefault();
        const userId = document.getElementById('userId');
        const name = document.getElementById('nameUpdate');
        const email = document.getElementById('emailUpdate');
        const password = document.getElementById('passwordUpdate');
        const phone = document.getElementById('phoneUpdate');
        const cep = document.getElementById('cepUpdate');
        const city = document.getElementById('cityUpdate');
        const address = document.getElementById('addressUpdate');
        const states = document.getElementById('statesUpdate');
        const description = document.getElementById('descriptionUpdate');


        fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: userId.value,
                name: name.value,
                email: email.value,
                password: password.value,
                phone: phone.value,
                cep: cep.value,
                city: city.value,
                address: address.value,
                states: states.value,
                description: description.value,
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'sucesso') {
                    location.reload();
                } else {
                    alert('Erro ao atualizar usuário: ' + data.mensagem);
                }
            })
            .catch(error => {
                console.error('Erro ao atualizar usuário:', error);
            });
    });
}

function viewUser() {
    window.addEventListener('load', function () {
        const btnsViewUser = document.querySelectorAll('.view-user');
        const userIdInput = document.getElementById('userId');
        const nameUpdateInput = document.getElementById('nameUpdate');
        const descriptionUpdateInput = document.getElementById('descriptionUpdate');
        const emailUpdateInput = document.getElementById('emailUpdate');
        const phoneUpdateInput = document.getElementById('phoneUpdate');
        const addressUpdateInput = document.getElementById('addressUpdate');
        const cityUpdateInput = document.getElementById('cityUpdate');
        const cepUpdateInput = document.getElementById('cepUpdate');
        const statesUpdateInput = document.getElementById('statesUpdate');
        const passwordUpdateInput = document.getElementById('passwordUpdate');
        const viewer = document.getElementById('viewer-name');


        for (let index = 0; index < btnsViewUser.length; index++) {
            const btn = btnsViewUser[index];
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                const dataTarget = btn.getAttribute("data-userid");
                fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/view/${dataTarget}`)
                    .then(response => response.json())
                    .then(data => {

                        userIdInput.value = data.ID;
                        nameUpdateInput.value = data.billing_first_name;
                        descriptionUpdateInput.value = data.description;
                        emailUpdateInput.value = data.user_email;
                        phoneUpdateInput.value = data.billing_phone;
                        addressUpdateInput.value = data.billing_address_1;
                        cityUpdateInput.value = data.billing_city;
                        cepUpdateInput.value = data.billing_postcode;
                        statesUpdateInput.value = data.billing_state;
                        passwordUpdateInput.value = data.user_pass;
                        viewer.innerHTML = data.billing_first_name;
                    })
                    .catch(error => console.error('Erro ao buscar detalhes do usuário:', error));
            });
        }
    });
}

function deleteUser() {
    window.addEventListener('load', function () {
        const deleteUser = document.getElementById("deleteUser");
        const messageDelete = document.getElementById("message");

        if (deleteUser) {
            deleteUser.addEventListener("click", () => {
                messageDelete.innerHTML = `
                <div class="popup" id="deleteConfirmationPopup">
                    <div class="popup-content">
                        <p>Tem certeza que deseja excluir o usuário?</p>
                        <div class="popup-buttons">
                            <button class="btn btn-sm btn-secondary" id="confirmCancel">Cancelar</button>
                            <button class="btn btn-sm btn-danger" id="confirmDelete">Sim, Excluir</button>
                        </div>
                    </div>
                </div>`;

                const popUp = document.getElementById("deleteConfirmationPopup");
                const confirmCancel = document.getElementById("confirmCancel");
                const confirmDelete = document.getElementById("confirmDelete");

                confirmCancel.addEventListener("click", () => {
                    popUp.remove(); // Remover o pop-up do DOM
                });

                confirmDelete.addEventListener("click", (event) => {
                    event.preventDefault();
                    const userIdInput = document.getElementById('userId')
                    fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/delete/userDelete=${userIdInput.value}`)
                        .then(response => response.json())
                        .then(data => {
                            location.reload()
                        })
                        .catch(error => {
                            console.error('Erro ao deletar o usuário:', error);
                        });
                    popUp.remove(); // Remover o pop-up do DOM
                });
            });
        }
    })
}

createUser();
updateUser();
viewUser();
deleteUser();

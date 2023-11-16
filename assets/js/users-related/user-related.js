function createUser() {
    window.addEventListener('show.bs.offcanvas', function () {
        const form = document.getElementById('form-create');
        if (form) {
            form.addEventListener('submit', (event) => {
                event.preventDefault();

                // Exibe a Sweet Alert para confirmar a criação do usuário
                Swal.fire({
                    title: 'Deseja criar usuário?',
                    text: 'Você tem certeza que deseja criar o usuário?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, Criar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Se o usuário confirmar, continua com a criação
                        const formData = new FormData(form);
                        const name = formData.get('name');
                        const email = formData.get('email');
                        const password = formData.get('password');
                        const billing_data = formData.get('billing_data');
                        const phone = formData.get('phone');
                        const role = formData.get('role');
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
                                role: role,
                                connected_user: connectedUser,
                                description: description,
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'sucesso') {
                                    Swal.fire('Sucesso!', 'Usuário criado com sucesso.', 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Erro!', 'Erro ao criar usuário: ' + data.mensagem, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Erro ao criar usuário:', error);
                            });
                    }
                });
            });
        }
    });
}


function updateUser() {
    window.addEventListener('show.bs.offcanvas', function () {
        const updateForm = document.getElementById('form-update');
        if (updateForm) {
            updateForm.addEventListener('submit', function (event) {
                event.preventDefault();

                // Exibe a Sweet Alert para confirmar a atualização
                Swal.fire({
                    title: 'Deseja Atualizar?',
                    text: 'Você tem certeza que deseja atualizar o usuário?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, Atualizar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(updateForm);
                        const userIDUpdate = formData.get('user_id');
                        const nameUpdate = formData.get('nameUpdate');
                        const emailUpdate = formData.get('emailUpdate');
                        const passwordUpdate = formData.get('passwordUpdate');
                        const phoneUpdate = formData.get('phoneUpdate');
                        const descriptionUpdate = formData.get('descriptionUpdate');

                        fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: userIDUpdate,
                                nameUpdate: nameUpdate,
                                emailUpdate: emailUpdate,
                                passwordUpdate: passwordUpdate,
                                phoneUpdate: phoneUpdate,
                                descriptionUpdate: descriptionUpdate,
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'sucesso') {
                                    Swal.fire('Sucesso!', 'Usuário atualizado com sucesso.', 'success').then(() => {
                                        location.reload();
                                    });
                                } else {

                                    Swal.fire('Erro!', 'Erro ao atualizar usuário: ' + data.mensagem, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Erro ao atualizar usuário:', error);
                            });
                    }
                });
            });
        }
    });
}

function viewUser() {
    window.addEventListener('show.bs.offcanvas', function () {
        const btnsViewUser = document.querySelectorAll('.view-user');
        const userIdInput = document.getElementById('userId');
        const nameUpdateInput = document.getElementById('nameUpdate');
        const descriptionUpdateInput = document.getElementById('descriptionUpdate');
        const phoneUpdateInput = document.getElementById('phoneUpdate');
        const emailUpdateInput = document.getElementById('emailUpdate');
        const passwordUpdateInput = document.getElementById('passwordUpdate');


        for (let index = 0; index < btnsViewUser.length; index++) {
            const btn = btnsViewUser[index];
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                const dataTarget = btn.getAttribute("data-userid");
                fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/view/${dataTarget}`, {
                    'Content-type': 'application/json',
                })
                    .then(response => response.json())
                    .then(data => {
                        userIdInput.value = data.ID;
                        nameUpdateInput.value = data.billing_first_name;
                        descriptionUpdateInput.value = data.description;
                        emailUpdateInput.value = data.user_email;
                        passwordUpdateInput.value = data.user_pass;
                        phoneUpdateInput.value = data.billing_phone;
                    })
                    .catch(error => console.error('Erro ao buscar detalhes do usuário:', error));
            });
        }
    });
}



function deleteUser() {
    window.addEventListener('show.bs.offcanvas', function () {
        const deleteUser = document.getElementById("deleteUser");
        if (deleteUser) {
            deleteUser.addEventListener("click", () => {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: 'Você não será capaz de reverter isso!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, Excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const userIdInput = document.getElementById('userId');
                        fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/delete/userDelete=${userIdInput.value}`)
                            .then(response => response.json())
                            .then(data => {
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Erro ao deletar o usuário:', error);
                            });
                    }
                });
            });
        }
    });
}


function tableCustom() {
    const wideMobile = document.getElementById('tableRelated');
    const screenWidth = window.screen.width;

    if (wideMobile) { // Verifica se o elemento foi encontrado
        wideMobile.dataset.pageSize = screenWidth > 900 ? '3' : '3';
    }
}



createUser();
updateUser();
viewUser();
deleteUser();
tableCustom();
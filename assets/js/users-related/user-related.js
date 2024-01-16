function createUser() {
    window.addEventListener('show.bs.offcanvas', function () {
        const loading = document.getElementById('loading');
        const form = document.getElementById('form-create');
        if (form) {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                loading.style.display = '';

                Swal.fire({
                    title: 'Deseja criar o Paciente?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00a9e7',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, Criar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const formData = new FormData(form);
                        const name = formData.get('name');
                        const email = formData.get('email');
                        const password = formData.get('password');
                        const billing_data = formData.get('billing_data');
                        const phone = formData.get('phone');
                        const connectedUser = formData.get('connected_user');
                        const description = formData.get('description');
                        const dateBirth = formData.get('date_birth');


                        fetch('/wp-json/adn-plugin/v1/users-related', {
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
                                connected_user: connectedUser,
                                description: description,
                                date_birth: dateBirth
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'sucesso') {
                                    loading.style.display = 'none';
                                    Swal.fire('Sucesso!', data.mensagem, 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    loading.style.display = 'none';
                                    Swal.fire('Erro!', data.mensagem, 'error');
                                }
                            })
                            .catch(error => {
                                loading.style.display = 'none';
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
        const loading = document.getElementById('loading');
        const updateForm = document.getElementById('form-update');
        if (updateForm) {
            updateForm.addEventListener('submit', function (event) {
                event.preventDefault();
                loading.style.display = '';

                Swal.fire({
                    title: 'Deseja Atualizar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00a9e7',
                    cancelButtonColor: '#dc3545',
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
                        const dateBirthUpdate = formData.get('date_birthUpdate');


                        fetch('/wp-json/adn-plugin/v1/users-related/update', {
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
                                date_birthUpdate: dateBirthUpdate,

                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'sucesso') {
                                    loading.style.display = 'none';
                                    Swal.fire('Sucesso!', data.mensagem, 'success').then(() => {
                                        // location.reload();
                                    });
                                } else {
                                    loading.style.display = 'none';
                                    Swal.fire('Erro!', data.mensagem, 'error');
                                }
                            })
                            .catch(error => {
                                loading.style.display = 'none';
                                console.error('Erro ao atualizar paciente:', error);
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
        const dateBirthInput = document.getElementById('date_birthUpdate');
        const phone_wpp = document.getElementById('phone_wpp');


        for (let index = 0; index < btnsViewUser.length; index++) {
            const btn = btnsViewUser[index];
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                const dataTarget = btn.getAttribute("data-userid");
                fetch(`/wp-json/adn-plugin/v1/users-related/view/${dataTarget}`, {
                    'Content-type': 'application/json',
                })
                    .then(response => response.json())
                    .then(data => {
                        userIdInput.value = data.ID;
                        nameUpdateInput.value = data.billing_first_name;
                        dateBirthInput.value = data.date_birth;
                        descriptionUpdateInput.value = data.description;
                        emailUpdateInput.value = data.user_email;
                        passwordUpdateInput.value = data.user_pass;
                        phoneUpdateInput.value = data.billing_phone;
                        phone_wpp.href = `https://wa.me/+55${data.billing_phone}`
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
                    confirmButtonColor: '#00a9e7',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, Excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const userIdInput = document.getElementById('userId');
                        fetch(`/wp-json/adn-plugin/v1/users-related/delete/userDelete=${userIdInput.value}`)
                            .then(response => response.json())
                            .then(data => {
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Erro ao deletar o Paciente:', error);
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

function cartCheckout() {
    window.addEventListener('show.bs.offcanvas', function () {
        const userRelatedId = document.querySelectorAll('[name="user_related_id"]');
        const btnsViewCart = document.querySelectorAll('.view-cart');
        
        for (let index = 0; index < btnsViewCart.length; index++) {
            const btn = btnsViewCart[index];
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                const dataTarget = btn.getAttribute("data-userid");
                userRelatedId.forEach((element, index) => {
                    element.value = dataTarget;
                });
            })
        }
    });
}

createUser();
updateUser();
viewUser();
deleteUser();
tableCustom();
cartCheckout();
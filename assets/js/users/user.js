function updateUser() {
  const formUpdate = document.getElementById('form-update');
  const loading = document.getElementById('loading');

  if (formUpdate) {
    const inputFile = document.getElementById('avatar_file');
    formUpdate.addEventListener('submit', (event) => {
      event.preventDefault();
      loading.style.display = '';

      Swal.fire({
        text: 'Deseja atualizar seu perfil?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData(formUpdate);
          formData.append('avatar_file', inputFile.files[0]);

          fetch('/wp-json/adn-plugin/v1/users/update', {
            method: 'POST',
            body: formData,
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.status === 'sucesso') {
                loading.style.display = 'none';
                Swal.fire('Sucesso!', 'Perfil criado com sucesso.', 'success').then(() => {
                  location.reload();
                });
              } else {
                loading.style.display = 'none';
                Swal.fire('Erro!', 'Erro ao criar um usuário: ' + data.mensagem, 'error');
              }
            })
            .catch((error) => {
              loading.style.display = 'none';

              console.error('Erro ao criar usuário:', error);
            });
        }
      });
    });
  }
}

updateUser();

function avatar() {
  const avatarInput = document.getElementById('avatar_file');
  const preview = document.getElementById('avatar-preview');

  if (avatarInput) {
    avatarInput.addEventListener('change', () => {
      const file = avatarInput.files[0];

      if (file) {
        const options = {
          quality: 0.6,
          success(result) {
            const reader = new FileReader();

            reader.onload = function (e) {
              preview.src = e.target.result;
            };
            reader.readAsDataURL(result);
          },
          error(err) {
            console.error('Erro ao redimensionar e comprimir a imagem:', err.message);
          },
        };
        new Compressor(file, options);
      }
    });
  }
}

avatar();

function viewUser() {
  window.addEventListener('load', function () {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const cepInput = document.getElementById('cep');
    const statesInput = document.getElementById('states');
    const CPF = document.getElementById('user_name');
    const userID = document.getElementById('userId');
    const avatar = document.getElementById('avatar-preview');

    fetch(`/wp-json/adn-plugin/v1/users/view/${userID.value}`, {
      method: 'GET',
    })
      .then(response => response.json())
      .then(data => {
        if (CPF) {
          CPF.innerHTML = data.user_nicename;
        }
        if (avatar) {
          avatar.src = data.billing_avatar;
        }
        nameInput.value = data.billing_first_name;
        emailInput.value = data.user_email;
        phoneInput.value = data.billing_phone;
        if (addressInput) {
          addressInput.value = data.billing_address_1;
          cityInput.value = data.billing_city;
          cepInput.value = data.billing_postcode;
          statesInput.value = data.billing_state;
        }

      })
      .catch(error => console.error('Erro ao buscar detalhes do usuário:', error));
  });
}

function showPassword() {
  const showPasswordIcon = document.getElementById('show-password');
  const passwordField = document.getElementById('user_pass');

  showPasswordIcon.addEventListener('click', function () {
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      showPasswordIcon.classList.remove('fa-eye');
      showPasswordIcon.classList.add('fa-eye-slash');
    } else {
      passwordField.type = 'password';
      showPasswordIcon.classList.remove('fa-eye-slash');
      showPasswordIcon.classList.add('fa-eye');
    }
  });
}

function refundOrder() {
  const forms = document.querySelectorAll('.form-refund');
  if (forms) {
    forms.forEach(form => {
      form.addEventListener('submit', (event) => {
        event.preventDefault();

        Swal.fire({
          title: 'Pedir Reembolso',
          text: 'Se você fizer o pedido de reembolso você não terá a assinatura de volta. Deseja mesmo?',
          iconHtml: '<i class="fas fa-rotate-left"></i>',
          showCancelButton: true,
          confirmButtonColor: '#0A3876',
          cancelButtonColor: '#dc3545',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            const formData = new FormData(form);
            const order_id = formData.get('order_id');

            fetch('/wp-json/adn-plugin/v1/users/refunded', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                order_id: order_id,
              })
            })
              .then(response => response.json())
              .then(data => {
                if (data.status === 'sucesso') {
                  Swal.fire('Sucesso!', data.mensagem , 'success').then(() => {
                    location.reload();
                  });
                } else {
                  Swal.fire('Erro!', data.mensagem, 'error');
                }
              })
              .catch(error => {
                console.error('Erro ao pedir reembolso:', error);
              });
          }
        });
      });
    });
  }
}
refundOrder();

updateUser();
viewUser();
showPassword();

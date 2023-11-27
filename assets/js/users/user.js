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

          fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users/update', {
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
              // Ocultar o loading em caso de erro
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
        // Configurações do Compressor.js
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
    const passwordInput = document.getElementById('user_pass');

    fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users/view/${userID.value}`)
      .then(response => response.json())
      .then(data => {
        CPF.innerHTML = data.user_login;
        passwordInput.value = data.user_pass;
        avatar.src = data.billing_avatar;
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


// function deleteUser() {
//   window.addEventListener('load', function () {
//     const deleteUser = document.getElementById("deleteUser");
//     const messageDelete = document.getElementById("message");

//     if (deleteUser) {
//       deleteUser.addEventListener("click", () => {
//         messageDelete.innerHTML = `
//               <div class="popup" id="deleteConfirmationPopup">
//                   <div class="popup-content">
//                       <p>Tem certeza que deseja excluir o usuário?</p>
//                       <div class="popup-buttons">
//                           <button class="btn btn-sm btn-secondary" id="confirmCancel">Cancelar</button>
//                           <button class="btn btn-sm btn-danger" id="confirmDelete">Sim, Excluir</button>
//                       </div>
//                   </div>
//               </div>`;

//         const popUp = document.getElementById("deleteConfirmationPopup");
//         const confirmCancel = document.getElementById("confirmCancel");
//         const confirmDelete = document.getElementById("confirmDelete");

//         confirmCancel.addEventListener("click", () => {
//           popUp.remove(); // Remover o pop-up do DOM
//         });

//         confirmDelete.addEventListener("click", (event) => {
//           event.preventDefault();
//           const userIdInput = document.getElementById('userId')
//           fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users-related/delete/userDelete=${userIdInput.value}`)
//             .then(response => response.json())
//             .then(data => {
//               location.reload()
//             })
//             .catch(error => {
//               console.error('Erro ao deletar o usuário:', error);
//             });
//           popUp.remove(); // Remover o pop-up do DOM
//         });
//       });
//     }
//   })
// }

updateUser();
viewUser();
// deleteUser();

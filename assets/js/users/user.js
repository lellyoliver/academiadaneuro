function createUser() {
  const form = document.getElementById('form-create');
  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const formData = new FormData(form);
      const name = formData.get('name');
      const email = formData.get('email');
      const billing_data = formData.get('billing_data');
      const city = formData.get('city');
      const phone = formData.get('phone');
      const role = formData.get('role');
      const password = formData.get('password');

      fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users', {
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
          phone: city,
          role: role,
        }),
      })
        .then(response => response.json())
        .then(data => {
          console.log(data)
          if (data.status === 'sucesso') {
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
  const inputFile = document.getElementById('avatar_file');

  formUpdate.addEventListener('submit', (event) => {
    event.preventDefault();
    Swal.fire({
      text: 'Deseja atualizar seu perfil?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sim',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData(formUpdate);
        formData.append('avatar_file', inputFile.files[0]);

        fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users/update', {
          method: 'POST',
          body: formData,
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'sucesso') {
              Swal.fire('Sucesso!', 'Perfil atualizado com sucesso.', 'success').then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Erro!', 'Erro ao atualizar o perfil: ' + data.mensagem, 'error');
            }
          })
          .catch(error => {
            console.error('Erro ao atualizar usuário:', error);
          });
      }

    });

  });
}

function avatar() {
  if(avatarInput){
    const avatarInput = document.getElementById('avatar_file');
    avatarInput.addEventListener('change', () => {
      const preview = document.getElementById('avatar-preview');
      const file = avatarInput.files[0];
      if (file) {
        const reader = new FileReader();
    
        reader.onload = function (e) {
          preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  }
}


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

    fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users/view/${userID.value}`)
      .then(response => response.json())
      .then(data => {
        CPF.innerHTML = data.user_login;

        try {
          document.getElementById('avatar-preview').src = data.billing_avatar;
        } catch (error) {
          document.getElementById('avatar-preview').src = `https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/user-perfil.svg`;
        }
        nameInput.value = data.billing_first_name;
        emailInput.value = data.user_email;
        phoneInput.value = data.billing_phone;
        addressInput.value = data.billing_address_1;
        cityInput.value = data.billing_city;
        cepInput.value = data.billing_postcode;
        statesInput.value = data.billing_state;
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

createUser();
updateUser();
viewUser();
// deleteUser();

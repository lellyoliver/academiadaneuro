// function createUser() {
//   const form = document.getElementById('form-create');
//   if (form) {
//     form.addEventListener('submit', (event) => {
//       event.preventDefault();
//       const formData = new FormData(form);
//       const name = formData.get('name');
//       const email = formData.get('email');
//       const password = formData.get('password');
//       const billing_data = formData.get('billing_data');
//       const phone = formData.get('phone');
//       const cep = formData.get('cep');
//       const address = formData.get('address');
//       const states = formData.get('states');
//       const role = formData.get('role');
//       const city = formData.get('city');
//       const connectedUser = formData.get('connected_user');
//       const description = formData.get('description');

//       fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users-related', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//           name: name,
//           email: email,
//           password: password,
//           billing_data: billing_data,
//           phone: phone,
//           cep: cep,
//           city: city,
//           address: address,
//           states: states,
//           role: role,
//           connected_user: connectedUser,
//           description: description,
//         })
//       })
//         .then(response => response.json())
//         .then(data => {
//           if (data.status === 'sucesso') {
//             location.reload()
//           } else {
//             alert('Erro ao atualizar usuário: ' + data.mensagem);
//           }
//         })
//         .catch(error => {
//           console.error('Erro ao atualizar usuário:', error);
//         });
//     });
//   }

// }

function updateUser() {
  const formUpdate = document.getElementById('form-update');

  formUpdate.addEventListener('submit', (event) => {
    event.preventDefault();
    const userId = document.getElementById('userId');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const cep = document.getElementById('cep');
    const city = document.getElementById('city');
    const address = document.getElementById('address');
    const states = document.getElementById('states');

    fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users/update', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        user_id: userId.value,
        name: name.value,
        email: email.value,
        phone: phone.value,
        cep: cep.value,
        city: city.value,
        address: address.value,
        states: states.value,
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
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const cepInput = document.getElementById('cep');
    const statesInput = document.getElementById('states');
    const userName = document.getElementById('user_name');
    const userID = document.getElementById('userId');

    fetch(`/academiadaneurociencia/wp-json/adn-plugin/v1/users/view/${userID.value}`)
      .then(response => response.json())
      .then(data => {
        userName.textContent = data.user_login;
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

// createUser();
updateUser();
viewUser();
// deleteUser();

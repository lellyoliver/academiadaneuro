const form = document.getElementById('form-create');

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
  const metaUser = formData.get('meta_user');

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
      cep: cep,
      city: city,
      address: address,
      states: states,
      role: role,
      meta_user: metaUser,
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'sucesso') {
        alert(data.mensagem);
      } else {
        console.log('Erro ao atualizar usuário: ' + data.mensagem);
      }
    })
    .catch(error => {
      console.error('Erro ao atualizar usuário:', error);
    });
});
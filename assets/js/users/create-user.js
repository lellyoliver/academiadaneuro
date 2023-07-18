const form = document.querySelector('#form-create');

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  const name = formData.get('name');
  const email = formData.get('email');
  const password = formData.get('password');
  const cnpj = formData.get('cnpj');
  const phone = formData.get('phone');
  const cep = formData.get('cep');
  const address = formData.get('address');
  const number_house = formData.get('number_house');
  const neighborhood = formData.get('neighborhood');
  const city = formData.get('city');
  const state = formData.get('state');

  fetch('/wp-json/brfng-plugin/v1/users', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      name: name,
      email: email,
      password: password,
      cnpj: cnpj,
      phone: phone,
      cep: cep,
      address: address,
      number_house: number_house,
      neighborhood: neighborhood,
      city: city,
      state: state,

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

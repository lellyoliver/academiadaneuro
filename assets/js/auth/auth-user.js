const form = document.querySelector('#login-form');
const errorElement = document.querySelector('#alert-form-login');

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const formData = new FormData(form);
  const email = formData.get('email');
  const password = formData.get('password');

  fetch('/wp-json/brfng-plugin/v1/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: email,
      password: password,
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'error') {
      errorElement.textContent = 'Usuário ou senha inválidos!';
    } else {
      setTimeout(function() {
        window.location.href = 'https://briefing.lellyoliver.com.br/';
      }, 2000);
    }
  })
  .catch(error => {
    console.error('Erro ao entrar:', error);
  });
});

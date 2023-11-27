function authLogin() {
  const formLogin = document.getElementById('form-login');
  if (formLogin) {
    formLogin.addEventListener('submit', (event) => {
      event.preventDefault();
      const formData = new FormData(formLogin);
      const cpf = formData.get('cpf');
      const password = formData.get('password');

      fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/auth/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          cpf: cpf,
          password: password,
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'sucesso') {
            console.log(data.message);
          } else {
            console.log(data.message);
          }
        })
        .catch(error => {
          console.error('Erro ao entrar:', error);
        });
    });
  }
}


function confirmEmail() {
  const form = document.querySelector('#form-auth-email');
  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      const formData = new FormData(form);
      const tokenAuth = formData.get('token');
      const userIDAuth = formData.get('user_id');

      fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/auth/email-confirmation', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          token: tokenAuth,
          user_id: userIDAuth,
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'sucesso') {
            window.location.href = "login";
          } else {
            console.log(data.status)
          }
        })
        .catch(error => {
          console.error('Erro ao entrar:', error);
        });
    });
  }
}

confirmEmail()

const queryString = window.location.search;
if (queryString.includes('?token=') || queryString.includes('&key=')) {
  const user_id = queryString.split('&key=')[1];
  const token = queryString.split('?token=')[1].replace(`&key=${user_id}`, "");
  const inputHiddenToken = document.getElementById('token');
  const inputHiddenUserID = document.getElementById('user_id');
  inputHiddenToken.value = token;
  inputHiddenUserID.value = user_id;
}


function forgotPassword() {
  const form = document.getElementById('form-auth-forgot-password');
  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      const formData = new FormData(form);
      const tokenAuth = formData.get('data_register');
      const div = document.getElementById("forgot-password");

      fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/auth/forgot-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          data_register: tokenAuth,
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.status == 'sucesso') {
            div.innerHTML = `${data.dataMessage}`;
          } else {
            console.log(data.status)
          }
        })
        .catch(error => {
          console.error('Erro ao entrar:', error);
        });
    });
  }
}

forgotPassword();
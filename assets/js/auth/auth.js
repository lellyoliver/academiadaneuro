function confirmEmail() {
  const form = document.querySelector('#form-auth-email');
  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      const formData = new FormData(form);
      const tokenAuth = formData.get('token');
      const userIDAuth = formData.get('user_id');

      fetch('/wp-json/adn-plugin/v1/auth/email-confirmation', {
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

      fetch('/wp-json/adn-plugin/v1/auth/forgot-password', {
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

function showPassword() {
  const showPasswordIcon = document.getElementById('show-password');
  const passwordField = document.getElementById('user-password');

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

showPassword();



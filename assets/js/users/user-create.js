function createUser() {
    const form = document.getElementById('form-create');
    const loading = document.getElementById('loading');
    if (form) {
      form.addEventListener('submit', (event) => {
        event.preventDefault();
  
        loading.style.display = '';
  
        const formData = new FormData(form);
        const name = formData.get('name');
        const email = formData.get('email');
        const billing_data = formData.get('billing_data');
        const city = formData.get('city');
        const phone = formData.get('phone');
        const role = formData.get('role');
        const password = formData.get('password');
        const termsAndServices = formData.get('termsAndServices');
  
        // Verifique se algum campo está vazio
        if (!name || !email || !billing_data || !city || !phone || !password || !role || !termsAndServices === "1") {
          const missingFields = [];
          if (!name) missingFields.push('Nome Completo');
          if (!billing_data) missingFields.push('CNPJ ou CPF');
          if (!email) missingFields.push('E-mail');
          if (!city) missingFields.push('Cidade');
          if (!phone) missingFields.push('Telefone');
          if (!role) missingFields.push('Área de Atuação');
          if (!password) missingFields.push('Senha');
          if (!termsAndServices) missingFields.push('Termos e Serviços');
  
          Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: `Por favor, preencha os seguintes campos: ${missingFields.join(', ')}.`,
          });
          return;
        }
  
        // Verifique a validade da senha
        if (!isPasswordValid(password)) {
          Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'A senha deve conter pelo menos 8 caracteres, incluindo pelo menos uma letra maiúscula e um número.',
          });
          return;
        }
  
        fetch('/academiadaneurociencia/wp-json/adn-plugin/v1/users', {
          method: 'POST',
          body: formData,
        })
          .then(response => response.json())
          .then(data => {
            // Ocultar o loading após a conclusão do envio
            loading.style.display = 'none';
            if (data.status === 'sucesso') {
              Swal.fire('Sucesso!', 'Obrigado por se cadastrar!.', 'success').then(() => {
                window.location.href = "login";
              });
            } else {
              loading.style.display = 'none';
              Swal.fire('error!', 'Erro ao se cadastrar!.', 'error').then(() => {
              });
            }
          })
          .catch(error => {
            console.error('Erro ao atualizar usuário:', error);
          });
      });
    }
  }
  
  function isPasswordValid(password) {
    const hasUpperCase = /[A-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    return password.length >= 8 && password.length <= 12 && hasUpperCase && hasNumber;
  }
  
  createUser();

function createSupport() {
    const form = document.getElementById('form-support');
    const loading = document.getElementById('loading');
    
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            loading.style.display = '';

            const formData = new FormData(form);

            fetch('/wp-json/adn-plugin/v1/customerSupport', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                if (data.status === 'sucesso') {
                    Swal.fire('Sucesso!', data.protocolo, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erro!', data.message, 'error').then(() => {
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao enviar suporte:', error);
                loading.style.display = 'none';
            });
        });
    }
}

createSupport();

function carrouselIcons() {

    const carousel = document.querySelector('.carousel-card');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    if (carousel) {
        prevButton.addEventListener('click', () => {
            carousel.scrollBy({
                left: -100,
                behavior: 'smooth'
            });
        });

        nextButton.addEventListener('click', () => {
            carousel.scrollBy({
                left: 100,
                behavior: 'smooth'
            });
        });
    }
}
carrouselIcons();
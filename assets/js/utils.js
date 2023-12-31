window.addEventListener("DOMContentLoaded", function () {

    function activeLink() {
        const currentURL = window.location.href;
        const linkURL = document.querySelectorAll(".nav-link");
        if (linkURL) {
            linkURL.forEach(links => {
                if (currentURL == links.href) {
                    links.classList.add("active-link");
                }
            });
        }
    }
    activeLink();
    
    function offcanvasNav() {
        const offcanvasContent = document.getElementById('navbarNav');

        if (offcanvasContent) {
            const closeButton = document.getElementById('closeOffcanvas');
            let touchStartX = null;

            function closeOffcanvas() {
                offcanvasContent.style.animation = 'slideOutLeft 0.3s';
                setTimeout(() => {
                    offcanvasContent.classList.remove("show");
                    offcanvasContent.style.animation = '';
                }, 300);
                touchStartX = null;
            }

            closeButton.addEventListener("click", closeOffcanvas);

            document.addEventListener("touchstart", (event) => {
                if (!offcanvasContent.contains(event.target)) {
                    closeOffcanvas();
                }
            });

            document.addEventListener("touchmove", (event) => {
                if (touchStartX !== null && event.touches[0].clientX - touchStartX <= -20) {
                    closeOffcanvas();
                }
            });

            document.addEventListener("touchstart", (event) => {
                touchStartX = event.touches[0].clientX;
            });

            document.addEventListener("touchend", () => {
                touchStartX = null;
            });
        }
    }
    offcanvasNav();

    function accordionDashboard() {
        const accordionHeaders = document.querySelectorAll('.accordion-header');
        for (let i = 0; i < accordionHeaders.length; i++) {
            accordionHeaders[i].addEventListener('click', function () {
                const accordionArrow = this.querySelector('.accordion-arrow i');
                if (accordionArrow.classList.contains('rotate')) {
                    accordionArrow.classList.remove('rotate');
                } else {
                    accordionArrow.classList.add('rotate');
                }
            });
        }
    }
    accordionDashboard();

});

function formatCPFOrCNPJ(value) {
    value = value.replace(/\D/g, '');

    if (value.length <= 11) {
        // Formatar como CPF
        // Implementação do formato CPF
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else {
        // Formatar como CNPJ
        // Implementação do formato CNPJ
        value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    }

    return value;
}

function formatCEP(value) {
    value = value.replace(/\D/g, '');
    if (value.length == 8) {
        value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
    }
    return value;
}

function formatPhone(value) {
    value = value.replace(/\D/g, '');
    if (value.length == 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    }
    return value;
}


function authAnimate() {
    const box = document.querySelector('.box-signin-text');
    const box_2 = document.querySelector('.box-signin-text-2');

    if (box && box_2) {
        box.addEventListener('mousemove', function (e) {
            let xPos = (e.clientX / window.innerWidth - 0.5) * 90;
            let yPos = (e.clientY / window.innerHeight - 0.5) * 90;

            this.style.transition = 'transform 0.2s ease-out';
            this.style.transform = 'translate(' + xPos + 'px, ' + yPos + 'px)';
        });

        box.addEventListener('mouseleave', function () {
            this.style.transition = 'transform 0.2s ease-in-out';
            this.style.transform = 'translate(0, 0)';
        });

        box_2.addEventListener('mousemove', function (e) {
            let xPos = (e.clientX / window.innerWidth - 0.5) * 90;
            let yPos = (e.clientY / window.innerHeight - 0.5) * 90;

            this.style.transition = 'transform 0.2s ease-out';
            this.style.transform = 'translate(' + xPos + 'px, ' + yPos + 'px)';
        });

        box_2.addEventListener('mouseleave', function () {
            this.style.transition = 'transform 0.2s ease-in-out';
            this.style.transform = 'translate(0, 0)';
        });
    }

}

authAnimate();
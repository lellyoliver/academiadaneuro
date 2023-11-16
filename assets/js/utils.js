window.addEventListener("DOMContentLoaded", function () {
    function offcanvasNav() {
        const closeButton = document.getElementById('closeOffcanvas');
        const offcanvasContent = document.getElementById('navbarNav');
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


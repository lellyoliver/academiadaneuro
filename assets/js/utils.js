function offcanvasNav() {
    if (document.getElementById('closeOffcanvas')) {
        const button = document.getElementById('closeOffcanvas');
        const offcanvasContent = document.getElementById('navbarNav');

        button.addEventListener("click", () => {
            offcanvasContent.classList.remove("show");
        });
    }
}

offcanvasNav();

window.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".input-text")) {
        const inputText = document.querySelectorAll(".input-text");
        if (inputText) {

            for (let i = 0; i < inputText.length; i++) {
                inputText[i].classList.replace("input-text", "form-control");
            }

            const inputSelect = document.querySelector(".country_select");
            inputSelect.classList.add("form-select");
        }

        const orderHeading = document.getElementById('order_review_heading');
        const orderReview = document.getElementById('order_review');
        const paymentDiv = document.getElementById('payment');
        const col2 = document.querySelector('.col-2')
        if (orderHeading && orderReview) {
            orderReview.insertBefore(orderHeading, orderReview.firstChild);
        }
        if (orderReview && paymentDiv) {
            orderReview.parentNode.insertBefore(paymentDiv, orderReview.nextSibling);
        }
        if (col2 && orderReview) {
            col2.appendChild(orderReview);
        }

    }
});
// function verifyStringData(billingData, billingCEP, billingPhone) {
//     const billingDataInput = document.getElementById(billingData);

//     billingDataInput.addEventListener('input', () => {
//         let value = billingDataInput.value.replace(/\D/g, '');

//         if (value.length <= 11) {
//             // Formatar como CPF
//             if (value.length > 3 && value.length <= 6) {
//                 value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
//             } else if (value.length > 6 && value.length <= 9) {
//                 value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
//             } else if (value.length > 9) {
//                 value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
//             }
//         } else {
//             // Formatar como CNPJ
//             value = value.slice(0, 14); // Limitar a 14 dígitos
//             value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
//         }

//         billingDataInput.value = value;

//     });

//     const cepInput = document.getElementById(billingCEP);
//     cepInput.addEventListener('input', () => {
//         let value = cepInput.value.replace(/\D/g, '');
//         if (value.length === 8) {
//             value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
//         }
//         cepInput.value = value;
//     });

//     const phoneInput = document.getElementById(billingPhone);
//     phoneInput.addEventListener('input', () => {
//         let value = phoneInput.value.replace(/\D/g, '');
//         if (value.length === 11) {
//             value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
//         }
//         phoneInput.value = value;
//     })

// }

// verifyStringData('', 'cep', 'phone');

// document.addEventListener("DOMContentLoaded", function () {
//     setTimeout(function () {
//         const loader = document.getElementById("loader");
//         loader.style.display = "none";

//         const conteudo = document.getElementById("conteudo");
//         conteudo.style.display = "block";
//     }, 2000);
// });

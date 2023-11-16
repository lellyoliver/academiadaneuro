// function formatCPFOrCNPJ(value) {
//     value = value.replace(/\D/g, '');

//     if (value.length <= 11) {
//         // Formatar como CPF
//         // Implementação do formato CPF
//         value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
//     } else {
//         // Formatar como CNPJ
//         // Implementação do formato CNPJ
//         value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
//     }

//     return value;
// }

// function formatCEP(value) {
//     value = value.replace(/\D/g, '');
//     if (value.length === 8) {
//         value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
//     }
//     return value;
// }

// function formatPhone(value) {
//     value = value.replace(/\D/g, '');
//     if (value.length === 11) {
//         value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
//     }
//     return value;
// }

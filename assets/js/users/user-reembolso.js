document.addEventListener('DOMContentLoaded', function() {
    const refundButtons = document.querySelectorAll('.refund-button');
    
    refundButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');

            Swal.fire({
                title: 'Pedir Reembolso',
                text: 'Se você fizer o pedido de reembolso você não terá a assinatura de volta. Deseja mesmo?',
                iconHtml: '<i class="fas fa-rotate-left"></i>',
                showCancelButton: true,
                confirmButtonColor: '#00a9e7',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/wp-json/adn-plugin/v1/users/refunded', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'sucesso') {
                            Swal.fire('Sucesso!', data.mensagem , 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Erro!', data.mensagem, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao pedir reembolso:', error);
                    });
                }
            });
        });
    });
});
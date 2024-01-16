function viewReplies() {
    window.addEventListener('show.bs.offcanvas', function () {
        const btnsViewUser = document.querySelectorAll('.view-user');
        const list_replies = document.getElementById('list-replies');

        for (let index = 0; index < btnsViewUser.length; index++) {
            const btn = btnsViewUser[index];
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                const dataTarget = btn.getAttribute("data-userid");
                fetch(`/wp-json/adn-plugin/v1/dashboard/replies/${dataTarget}`, {
                    'Content-type': 'application/json',
                })
                    .then(response => response.json())
                    .then(data => {
                        list_replies.innerHTML = data.map(element => 
                            `<div class="col-md-4 mb-3">
                                <div class="card-training">
                                    <div class="card-body">
                                        ${element}
                                    </div>
                                </div>
                            </div>`).join('');
                    })
                    .catch(error => console.error('Erro ao buscar detalhes do usuário:', error));
            });
        }
    });
}

viewReplies();
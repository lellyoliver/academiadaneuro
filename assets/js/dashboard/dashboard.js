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
                        console.log(data);
                        list_replies.innerHTML = data.map(element =>
                            `<div class="col-md-4 mb-3">
                                <div class="card-training">
                                    <div class="card-body">
                                        <h6 class="card-title">${element.training}</h6>
                                        <p class="card-text">Progresso: ${element.porcentagem}%</p>
                                    </div>
                                </div>
                            </div>`
                        ).join('');
                    })
                    .catch(error => console.error('Erro ao buscar detalhes do usuário:', error));
            });
        }
    });
}

viewReplies();


document.getElementById('search-patient').addEventListener('input', filterNames);

function filterNames() {
    const input = document.getElementById('search-patient').value.toLowerCase();
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
        const nameAttribute = item.getAttribute('data-name-user').toLowerCase();

        if (nameAttribute.includes(input)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
filterNames();

function updatePagination() {
    const accordionItems = document.querySelectorAll('.accordion-item:not(.hidden)');
    const itemsPerPage = 5;

    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    const numPages = Math.ceil(accordionItems.length / itemsPerPage);
    const maxPagesToShow = 5; // Número máximo de páginas a serem exibidas

    function createPageItem(pageNumber, isActive = false) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (isActive) li.classList.add('active');

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.href = '#';
        a.textContent = pageNumber;

        a.addEventListener('click', function (event) {
            event.preventDefault();
            showPage(pageNumber, itemsPerPage, accordionItems);
            updatePagination(pageNumber); // Atualiza a paginação para refletir a página atual
        });

        li.appendChild(a);
        return li;
    }

    function addEllipsis() {
        const li = document.createElement('li');
        li.classList.add('page-item', 'disabled');

        const span = document.createElement('span');
        span.classList.add('page-link');
        span.textContent = '...';

        li.appendChild(span);
        paginationContainer.appendChild(li);
    }

    function updatePagination(currentPage = 1) {
        paginationContainer.innerHTML = '';

        if (numPages <= maxPagesToShow) {
            for (let i = 1; i <= numPages; i++) {
                paginationContainer.appendChild(createPageItem(i, i === currentPage));
            }
        } else {
            if (currentPage <= maxPagesToShow - 2) {
                for (let i = 1; i <= maxPagesToShow - 1; i++) {
                    paginationContainer.appendChild(createPageItem(i, i === currentPage));
                }
                addEllipsis();
                paginationContainer.appendChild(createPageItem(numPages));
            } else if (currentPage > numPages - (maxPagesToShow - 2)) {
                paginationContainer.appendChild(createPageItem(1));
                addEllipsis();
                for (let i = numPages - (maxPagesToShow - 2); i <= numPages; i++) {
                    paginationContainer.appendChild(createPageItem(i, i === currentPage));
                }
            } else {
                paginationContainer.appendChild(createPageItem(1));
                addEllipsis();
                for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                    paginationContainer.appendChild(createPageItem(i, i === currentPage));
                }
                addEllipsis();
                paginationContainer.appendChild(createPageItem(numPages));
            }
        }
    }

    showPage(1, itemsPerPage, accordionItems);
    updatePagination();
}

function showPage(pageNumber, itemsPerPage, accordionItems) {
    const startIndex = (pageNumber - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;

    accordionItems.forEach((navs, index) => {
        if (index >= startIndex && index < endIndex) {
            navs.style.display = 'block';
        } else {
            navs.style.display = 'none';
        }
    });
}

updatePagination();
<ul id="pagination" class="pagination col-7_5 ml-auto d-flex justify-content-center">
    <li class="page-item anterior" onclick="mudarPagina('anterior')">
        <a class="page-link">Anterior</a>
    </li>
    <li class="page-item proxima" onclick="mudarPagina('proxima')">
        <a class="page-link">Próxima</a>
    </li>
</ul>

<script>
    let itens = document.querySelectorAll("#listagem_recursos_paginacao .col");
    let itensPorPagina = 20;
    let paginaAtual = 1;

    const ativar = (elemento) => {
        let itens = document.getElementsByClassName("page-item");
        for (let i = 0; i < itens.length; i++) {
            itens[i].classList.remove("active");
        }
        elemento.classList.add("active");
    };

    const atualizarPaginacao = () => {
        let inicio = (paginaAtual - 1) * itensPorPagina;
        let fim = inicio + itensPorPagina;

        itens.forEach((item, index) => {
            if (index >= inicio && index < fim) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    };

    const gerarPaginacao = () => {
        let totalPaginas = Math.ceil(itens.length / itensPorPagina);
        let paginationContainer = document.getElementById('pagination');

        let paginaButtons = paginationContainer.querySelectorAll('.page-item');
        paginaButtons.forEach(button => {
            if (!button.classList.contains('anterior') && !button.classList.contains('proxima')) {
                button.remove();
            }
        });

        for (let i = 1; i <= totalPaginas; i++) {
            let li = document.createElement('li');
            li.classList.add('page-item');
            li.setAttribute('onclick', `mudarPagina(${i})`);
            li.innerHTML = `<a class="page-link">${i}</a>`;
            paginationContainer.insertBefore(li, paginationContainer.querySelector('.proxima'));
        }

        let itensPagina = document.querySelectorAll(".pagination .page-item");
        itensPagina[1].classList.add("active");

        document.querySelector(".pagination .anterior").classList.add("disabled");

        if (paginaAtual === totalPaginas) {
            document.querySelector(".pagination .proxima").classList.add("disabled");
        }
    };

    const mudarPagina = (pagina) => {
        let totalPaginas = Math.ceil(itens.length / itensPorPagina);

        if (pagina === 'anterior') {
            if (paginaAtual > 1) {
                paginaAtual--;
            }
        } else if (pagina === 'proxima') {
            if (paginaAtual < totalPaginas) {
                paginaAtual++;
            }
        } else {
            paginaAtual = pagina;
        }

        atualizarPaginacao();

        let itensPagina = document.querySelectorAll(".pagination .page-item");
        itensPagina.forEach(item => item.classList.remove("active"));
        itensPagina[paginaAtual].classList.add("active");

        window.scrollTo(0, 280);

        if (paginaAtual === 1) {
            document.querySelector(".pagination .anterior").classList.add("disabled");
        } else {
            document.querySelector(".pagination .anterior").classList.remove("disabled");
        }

        if (paginaAtual === totalPaginas) {
            document.querySelector(".pagination .proxima").classList.add("disabled");
        } else {
            document.querySelector(".pagination .proxima").classList.remove("disabled");
        }
    };

    gerarPaginacao();
    atualizarPaginacao();
</script>
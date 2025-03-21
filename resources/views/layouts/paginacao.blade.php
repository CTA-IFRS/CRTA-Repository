<ul id="pagination" class="pagination col-7_5 ml-md-auto ml-0 d-flex justify-content-center" role="navigation" aria-label="Paginação">
    <li class="page-item anterior" onclick="mudarPagina('anterior')" tabindex="0" role="button" aria-label="Ir para página anterior">
        <a class="page-link">Anterior</a>
    </li>
    <li class="page-item proxima" onclick="mudarPagina('proxima')" tabindex="0" role="button" aria-label="Ir para próxima página">
        <a class="page-link">Próxima</a>
    </li>
</ul>

<script>
    let itens = document.querySelectorAll("#listagem_recursos_paginacao .col");
    let itensPorPagina = 4;
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

        let totalPaginas = Math.ceil(itens.length / itensPorPagina);
        let anteriorBtn = document.querySelector(".pagination .anterior");
        let proximaBtn = document.querySelector(".pagination .proxima");

        if (paginaAtual === 1) {
            anteriorBtn.classList.add("disabled");
            anteriorBtn.setAttribute("aria-disabled", "true");
            anteriorBtn.setAttribute("tabindex", "-1");
        } else {
            anteriorBtn.classList.remove("disabled");
            anteriorBtn.setAttribute("aria-disabled", "false");
            anteriorBtn.setAttribute("tabindex", "0");
        }

        if (paginaAtual === totalPaginas) {
            proximaBtn.classList.add("disabled");
            proximaBtn.setAttribute("aria-disabled", "true");
            proximaBtn.setAttribute("tabindex", "-1");
        } else {
            proximaBtn.classList.remove("disabled");
            proximaBtn.setAttribute("aria-disabled", "false");
            proximaBtn.setAttribute("tabindex", "0");
        }
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
            li.setAttribute('tabindex', '0');
            li.setAttribute('role', 'button');
            li.setAttribute('aria-label', `Ir para página ${i}`);
            li.innerHTML = `<a class="page-link">${i}</a>`;

            li.addEventListener('keydown', (e) => {
                if (e.key === "Enter" || e.key === " ") {
                    e.preventDefault();
                    li.click();
                }
            });
            
            paginationContainer.insertBefore(li, paginationContainer.querySelector('.proxima'));
        }

        let itensPagina = document.querySelectorAll(".pagination .page-item");
        if (itensPagina.length > 1) {
            itensPagina[1].classList.add("active");
        }

        document.querySelector(".pagination .anterior").classList.add("disabled");
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
    };

    document.querySelectorAll('.page-item').forEach(item => {
        item.addEventListener('keydown', (e) => {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                item.click();
            }
        });

        item.addEventListener('focus', () => {
            if (item.classList.contains('anterior')) {
                item.addEventListener('keydown', (e) => {
                    if (e.key === "ArrowLeft" || e.key === "ArrowUp") {
                        mudarPagina('anterior');
                    }
                });
            } else if (item.classList.contains('proxima')) {
                item.addEventListener('keydown', (e) => {
                    if (e.key === "ArrowRight" || e.key === "ArrowDown") {
                        mudarPagina('proxima');
                    }
                });
            }
        });

        item.addEventListener('blur', () => {
        });
    });

    gerarPaginacao();
    atualizarPaginacao();
</script>
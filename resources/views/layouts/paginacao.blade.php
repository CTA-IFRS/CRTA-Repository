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
    let itensPorPagina = 12;
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

        anteriorBtn.classList.toggle("disabled", paginaAtual === 1);
        anteriorBtn.setAttribute("aria-disabled", paginaAtual === 1);
        anteriorBtn.setAttribute("tabindex", paginaAtual === 1 ? "-1" : "0");

        proximaBtn.classList.toggle("disabled", paginaAtual === totalPaginas);
        proximaBtn.setAttribute("aria-disabled", paginaAtual === totalPaginas);
        proximaBtn.setAttribute("tabindex", paginaAtual === totalPaginas ? "-1" : "0");
    };

    const maxBotoesVisiveis = 4;

    const gerarPaginacao = () => {
        let totalPaginas = Math.ceil(itens.length / itensPorPagina);
        let paginationContainer = document.getElementById('pagination');

        let paginaButtons = paginationContainer.querySelectorAll('.page-item');
        paginaButtons.forEach(button => {
            if (!button.classList.contains('anterior') && !button.classList.contains('proxima')) {
                button.remove();
            }
        });

        const criarBotao = (i) => {
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
        };

        const criarElipse = () => {
            let li = document.createElement('li');
            li.classList.add('page-item', 'disabled');
            li.innerHTML = `<a class="page-link">...</a>`;
            paginationContainer.insertBefore(li, paginationContainer.querySelector('.proxima'));
        };

        if (totalPaginas <= 5) {
            for (let i = 1; i <= totalPaginas; i++) {
                criarBotao(i);
            }
        } else {
            criarBotao(1);

            if (paginaAtual <= 2) {
                criarBotao(2);
                criarBotao(3);
                criarElipse();
            } else if (paginaAtual >= totalPaginas - 1) {
                criarElipse();
                criarBotao(totalPaginas - 2);
                criarBotao(totalPaginas - 1);
            } else {
                criarElipse();
                criarBotao(paginaAtual);
                criarBotao(paginaAtual + 1);
                criarElipse();
            }

            criarBotao(totalPaginas);
        }

        let botoes = document.querySelectorAll(".pagination .page-item");
        botoes.forEach((btn) => {
            if (btn.innerText == paginaAtual) {
                btn.classList.add("active");
            }
        });
    };


    const mudarPagina = (pagina) => {
        let totalPaginas = Math.ceil(itens.length / itensPorPagina);

        if (pagina === 'anterior' && paginaAtual > 1) {
            paginaAtual--;
        } else if (pagina === 'proxima' && paginaAtual < totalPaginas) {
            paginaAtual++;
        } else if (typeof pagina === 'number') {
            paginaAtual = pagina;
        }

        atualizarPaginacao();
        gerarPaginacao();
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
    });

    gerarPaginacao();
    atualizarPaginacao();
</script>
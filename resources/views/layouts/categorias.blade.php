<nav id="navegacaoCategorias" class="navbar navbar-expand-lg navbar-light bg-transparent shadow-sm">
    <a class="navbar-brand" href="#">Buscar por categorias: </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('filtroTag', ['mobilidade'])}}">Mobilidade</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('filtroTag', ['comunicação'])}}">Comunicação</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('filtroTag', ['audição'])}}">Audição</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('filtroTag', ['visão'])}}">Visão</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('filtroTag', ['cognitivas'])}}">Cognitivas</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('filtroTag', ['acessibilidade digital'])}}">Acessibilidade Digital</a>
            </li>
        </ul>
    </div>
</nav>
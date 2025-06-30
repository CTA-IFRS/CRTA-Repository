<nav id="navegacaoCategorias" class="navbar navbar-expand-lg navbar-light shadow-sm bg-white">
    <a class="navbar-brand" href="#" tabindex="-1">Buscar por: </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav flex-wrap">
            <li class="nav-item">
                <a class="nav-link" href="{{route('filtroTag', ['software'])}}">Software</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('filtroTag', ['deficiência visual'])}}">Deficiência visual</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('filtroTag', ['mouse adaptado'])}}">Mouse adaptado</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('filtroTag', ['deficiência física'])}}">Deficiência física</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('filtroTag', ['baixo custo'])}}">Baixo custo</a>
            </li>
        </ul>
    </div>
</nav>
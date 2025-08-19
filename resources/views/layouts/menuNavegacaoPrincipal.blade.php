<!-- Menu a ser exibido na tela principal, contendo imagem -->
<div class="menuTelaPrincipal d-flex flex-row justify-content-between shadow-sm">
<h1><a class="navbar-brand" href="{{ url('/') }}"><span class="h4">RETACE</span></a></h1>
<nav class="navbar navbar-expand-lg navbar-light p-0"
	aria-label="Menu de navegação principal">
	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navegacaoPrincipal" aria-controls="navegacaoPrincipal" aria-expanded="false" aria-label="{{ __('Expandir menu') }}">
    	<span class="navbar-toggler-icon"></span>
  	</button>

	<a href="#" id="menu-principal" class="sr-only">Início do menu</a>
	<div id="navegacaoPrincipal" class="collapse navbar-collapse">
		<ul class="navbar-nav col-xs-9">
			  <li class="nav-item">
				<a class="nav-link {{ Request::is('filtro/tag/tecnologia assistiva') ? 'selected' : '' }}" href="{{ route('filtroTag', ['tecnologia assistiva']) }}">Tecnologia assistiva</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('filtro/tag/material pedagógico') ? 'selected' : '' }}" href="{{ route('filtroTag', ['material pedagógico']) }}">Material pedagógico</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('contribuir-ta') ? 'selected' : '' }}" href="{{ route('cadastrarTA') }}">Contribuir</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('aprender') ? 'selected' : '' }}" href="{{ url('/aprender') }}">Aprender</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('sobre') ? 'selected' : '' }}" href="{{ url('/sobre') }}">Sobre</a>
			</li>  
      	</ul>
	</div>
	<a href="#" class="sr-only">Final do menu</a>
</nav>
</div>
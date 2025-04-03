<!-- Menu a ser exibido na tela principal, contendo imagem -->
<nav class="menuTelaPrincipal navbar navbar-expand-lg navbar-light shadow-sm"
	aria-label="Menu de navegação principal">
	<h1><a class="navbar-brand" href="{{ url('/') }}"><span class="h4">RETACE</span></a></h1>
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
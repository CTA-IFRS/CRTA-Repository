<!-- Menu a ser exibido na tela principal, contendo imagem -->
<nav class="menuTelaPrincipal navbar navbar-expand-lg navbar-dark bg-primary">
	<a class="navbar-brand" href="{{ url('/') }}">RETACE</a>
	<button type="button" class="navbar-toggler bg-primary" data-toggle="collapse" data-target="#navegacaoPrincipal" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Expandir menu') }}">
    	<span class="navbar-toggler-icon"></span>
  	</button>
	<div id="navegacaoPrincipal" class="collapse navbar-collapse">
		<ul class="navbar-nav mr-auto col-xs-9">
      		<li class="nav-item">
        		<a class="nav-link" href="#"><u>Sobre</u></a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#"><u>Aprender</u></a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#"><u>Contribuir</u></a>
      		</li>
      	</ul>
      	<ul class="navbar-nav navbar-right col-xs-3">
      		<li class="nav-item my-2 my-lg-0">
        		<a class="nav-link" href="#"><u> Facebook </u></a>
      		</li>
      		<li class="nav-item my-2 my-lg-0">
        		<a class="nav-link" href="#"><u> YouTube </u></a>
      		</li>
      	</ul>
	</div>
</nav>
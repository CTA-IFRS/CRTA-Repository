<!-- Menu a ser exibido na tela principal, contendo imagem -->
<nav class="menuTelaPrincipal navbar navbar-expand-lg navbar-dark bg-primary">
	<a class="navbar-brand" href="{{ url('/') }}">RETACE</a>
	<button type="button" class="navbar-toggler bg-primary" data-toggle="collapse" data-target="#navegacaoPrincipal" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Expandir menu') }}">
    	<span class="navbar-toggler-icon"></span>
  	</button>
	<div id="navegacaoPrincipal" class="collapse navbar-collapse">
		<ul class="navbar-nav mr-auto col-xs-9">
      		<li class="nav-item">
        		<a class="nav-link dottedUnderline" href="{{ url('/sobre')}}">Sobre</a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link dottedUnderline" href="{{ url('/aprender')}}">Aprender</a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link dottedUnderline" href="{{url('/cadastrarTA')}}">Contribuir</a>
      		</li>
      	</ul>
      	<ul class="navbar-nav navbar-right col-xs-3">
      		<li class="nav-item my-2 my-lg-0">
        		<a class="nav-link" href="https://www.facebook.com/ctaifrs/"><img class="iconePequeno" src="{{url('/imagens/f_logo_white.png')}}" alt="Facebook"/></a>
      		</li>
      		<li class="nav-item my-2 my-lg-0">
        		<a class="nav-link" href="https://www.youtube.com/c/CTA-IFRS/"><img class="iconePequeno pt-1" src="{{url('/imagens/youtube_social_icon_white.png')}}" alt="YouTube"/></a>
      		</li>
      	</ul>
	</div>
</nav>
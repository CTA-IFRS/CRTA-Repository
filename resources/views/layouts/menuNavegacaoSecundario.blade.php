<!-- barra de navegação secundária -->
<nav class="menuNavegacaoSecundario navbar navbar-expand-lg navbar-dark bg-secondary fixed-top py-0 py-sm-2"
aria-label="Menu de navegação secundário">
  <button type="button" class="navbar-toggler bg-secondary" data-toggle="collapse" data-target="#navegacaoSecundaria" aria-controls="navegacaoSecundaria" aria-expanded="false" aria-label="{{ __('Expandir menu') }}">
    <span class="navbar-toggler-icon"></span>
  </button>
	<div id="navegacaoSecundaria" class="collapse navbar-collapse">
		    <ul class="navbar-nav">
      		<li class="nav-item">
        		<a class="nav-link" href="#conteudo-principal" accesskey="1"> Ir para o conteúdo
              <span class="badge badge-primary">1</span>
            </a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#menu-principal" accesskey="2"> Ir para o menu
              <span class="badge badge-primary">2</span>
            </a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#caixa-de-busca" accesskey="3">Ir para a busca
              <span class="badge badge-primary">3</span>
            </a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#inicio-rodape" accesskey="4"> Ir para o rodapé
              <span class="badge badge-primary">4</span>
            </a>
      		</li>
      	</ul>
      	<ul class="navbar-nav navbar-right ml-auto">
      		<li class="nav-item my-2 my-md-0">
        		<a class="nav-link dottedUnderline" href="{{route('acessibilidade')}}">ACESSIBILIDADE</a>
      		</li>
      		<li class="nav-item my-2 my-md-0">
        		<a class="nav-link dottedUnderline" href="{{route('mapaDoSite')}}">MAPA DO SITE </a>
      		</li>        
			<li class="nav-item my-2 my-md-0">
				<a class="nav-link" href="{{url('/entrar')}}"><u> Entrar <span class="sr-only">na área do administrador</span></u></a>
			</li>
      	</ul>
	</div>
</nav>
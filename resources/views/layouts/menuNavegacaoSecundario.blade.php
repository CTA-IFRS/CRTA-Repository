<!-- barra de navegação secundária -->
<nav class="menuNavegacaoSecundario navbar navbar-expand-lg navbar-light bg-secondary fixed-top py-0 py-sm-2"
aria-label="Menu de navegação secundário">
  <button type="button" class="navbar-toggler bg-secondary" data-toggle="collapse" data-target="#navegacaoSecundaria" aria-controls="navegacaoSecundaria" aria-expanded="false" aria-label="{{ __('Expandir menu') }}">
    <span class="navbar-toggler-icon"></span>
  </button>
	<div id="navegacaoSecundaria" class="collapse navbar-collapse">
		    <ul class="navbar-nav">
      		<li class="nav-item">
        		<a class="nav-link" href="#conteudo-principal" accesskey="1"> Ir para o conteúdo
              <span class="badge badge-light">1</span>
            </a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#menu-principal" accesskey="2"> Ir para o menu
              <span class="badge badge-light">2</span>
            </a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#caixa-de-busca" accesskey="3">Ir para a busca
              <span class="badge badge-light">3</span>
            </a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#inicio-rodape" accesskey="4"> Ir para o rodapé
              <span class="badge badge-light">4</span>
            </a>
      		</li>
      	</ul>
      	<ul class="navbar-nav navbar-right ml-auto">
		  	<li class="nav-item my-2 my-md-0 mr-2">
        		<a class="nav-link dottedUnderline" id="ativar-altocontraste" href="#"></a>
      		</li>
      		<li class="nav-item my-2 my-md-0">
        		<a class="nav-link dottedUnderline" href="{{route('acessibilidade')}}"><i class="fa fa-check-square mr-1"></i> Acessibilidade</a>
      		</li>
      	</ul>
	</div>
</nav>

@section('scripts')

@endsection
@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	@include('layouts.caixaDeBusca')
	<div id="resultadoBusca" class="mt-3">
		@if($buscaPorTag)
			<h2 class="h3"> Resultado da busca por

				@foreach($parametro as $param)
					<h3 class="d-inline-block h2"> 
						<a href="#" class="badge badge-primary">
							{{$param}}
						</a>
					</h3>
				@endforeach
			</h2>
		@elseif(strlen($parametro)!=0)
			<h2 class="h3"> Resultado da busca por <i>{{$parametro}}</i> </h2>
		@else
			<h2 class="h3"> Buscando por todos os recursos, exibindo os mais acessados primeiro </h2>
		@endif
		@include('layouts.listaCardsRecursos')
	</div>
</div>
@endsection


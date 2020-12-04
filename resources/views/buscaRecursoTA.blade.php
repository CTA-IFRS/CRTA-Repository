@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	@include('layouts.caixaDeBusca')
	<div id="resultadoBusca" class="mt-3">
		@if($buscaPorTag)
			<h3> Resultado da busca por

				@foreach($parametro as $param)
					<h2 class="d-inline-block"> 
						<a href="#" class="badge badge-primary">
							{{$param}}
						</a>
					</h2>
				@endforeach
			</h3>
		@elseif(strlen($parametro)!=0)
			<h3> Resultado da busca por <i>{{$parametro}}</i> </h3>
		@else
			<h3> Buscando por todos os recursos, exibindo os mais acessados primeiro </h3>
		@endif
		@include('layouts.listaCardsRecursos')
	</div>
</div>
@endsection


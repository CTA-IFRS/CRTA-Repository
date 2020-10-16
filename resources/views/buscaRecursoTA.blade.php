@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	@include('layouts.caixaDeBusca')
	<div id="resultadoBusca" class="mt-3">
		@if($buscaPorTag)
			<h3> Resultado da busca por <i>{{$parametro}}</i> </h3>
		@else
			<h3> Resultado da busca por <i>{{$parametro}}</i> </h3>
		@endif
		@include('layouts.listaCardsRecursos')
	</div>
</div>
@endsection


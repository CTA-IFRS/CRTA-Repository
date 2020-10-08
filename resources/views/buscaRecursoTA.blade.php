@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	<div class="input-group">
		<input type="text" class="form-control" placeholder="Digite um termo para r">
		<div class="input-group-append">
			<button class="btn btn-secondary" type="button">
				<i class="fa fa-search"></i>
			</button>
		</div>
	</div>
	<h3> Resultado da busca pela tag <i>{{$tag}}</i> </h3>
	@include('listaCardsRecursos')
</div>
@endsection


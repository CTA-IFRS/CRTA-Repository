@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	<h3> Resultado da busca pela tag <i>{{$tag}}</i> </h3>
	@include('listaCardsRecursos')
</div>
@endsection


@extends('layouts.siteLayout')

@section('titulo','RETACE Início')

@section('bannerTelaInicial')
	@include('layouts.bannerTelaInicial')
@endsection
@section('conteudo')
	<h1 class="m-5">Recursos de Tecnologia Assistiva</h1>
	@include('listaCardsRecursos')
@endsection


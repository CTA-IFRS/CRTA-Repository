@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
            ['name' => "Resultado da busca", 'current' => true]
        ]
    ?>
    <div class="row breadcrumb-clear-pad">
        <div class="col">
            @include('layouts.breadcrumb', $data)
        </div>
    </div>
</div>

<div class="container mt-3">
    <a href="#" id="caixa-de-busca" class="sr-only">Início da caixa de busca</a>
	@include('layouts.caixaDeBusca')
    <a href="#" class="sr-only">Final da caixa de busca</a>
	<div id="resultadoBusca" class="mt-3">
		@if(strlen($parametro)!=0)
			<h2 class="h3"> Resultado da busca por <i>{{$parametro}}</i> </h2>
		@else
			<h2 class="h3"> Buscando por todos os recursos, exibindo os mais acessados primeiro </h2>
		@endif
		@include('layouts.listaCardsRecursos')
	</div>
</div>
@endsection


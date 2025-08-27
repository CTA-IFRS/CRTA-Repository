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
</div>
<div class="container-xl">
    <div id="resultadoBusca" class="mt-4 mt-sm-5">
		@if(strlen($parametro)!=0)
			<h2 class="h3"> 
                <span>Resultado da busca por <i>{{$parametro}}</i></span>
                @if (isset($filtros) && count($filtros) > 0)
                    @foreach ($filtros as $t)
                        <span>, {{$t}}</span> 
                    @endforeach
                @endif
            </h2>
		@elseif (count($filtros) != 0)
			<h2 class="h3"> Resultado da busca por {{implode(', ', $filtros)}} </h2>
        @endif
		@include('layouts.listaCardsRecursos')
	</div>
</div>
@endsection


@extends('layouts.siteLayout')
@section('titulo','RETACE - Aprender')
@section('conteudo')

<div class="container mt-5">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
            ['name' => 'Aprender', 'current' => true]
        ]
    ?>
    <div class="row breadcrumb-clear-pad">
        <div class="col">
            @include('layouts.breadcrumb', $data)
        </div>
    </div>
</div>

<div class="container card my-3">
	<div class="row">
        @if ($conteudoPagina->texto == '')
            <div class="col-12">
                <div class="row">
                    <h2 class="display-3 pl-4 h1">Aprender</h2>
                </div>
                <div class="row">
                    <p class="lead pl-4">Acesse materiais para estudar mais sobre Tecnologias Assistivas</p> 
                </div>
            </div>
        @endif

		<div id="conteudo" class="col-12 pt-2 pl-2" >
			<h3 class="display-4 h1 text-center mt-3 mb-5 ml-5 mr-5">
				{!! html_entity_decode(stripslashes($conteudoPagina->titulo_texto), ENT_QUOTES, 'UTF-8')!!} 
			</h3>
			<div class="my-3 ml-5 mr-5">
				{!! html_entity_decode(stripslashes($conteudoPagina->texto), ENT_QUOTES, 'UTF-8')!!}			
			</div>		
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {

	});
</script>
@endsection
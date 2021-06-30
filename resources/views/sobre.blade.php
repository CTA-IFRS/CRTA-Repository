@extends('layouts.siteLayout')
@section('titulo','RETACE - Sobre')
@section('conteudo')

<div class="container mt-5">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
            ['name' => 'Sobre', 'current' => true]
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
        <div class="col-12">
            <div class="row">
                <h2 class="display-3 pl-4 h1">Sobre</h2>
            </div>
            <div class="row">
                <p class="lead pl-4">Saiba mais sobre o RETACE</p> 
            </div>
        </div>
		<div id="conteudo" class="col-12 pt-5 pl-5" >
			<h3 class="display-4 h1">
				{!! html_entity_decode(stripslashes($conteudoPagina->titulo_texto), ENT_QUOTES, 'UTF-8')!!} 
			</h3>
			<div class="my-3 ml-5">
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
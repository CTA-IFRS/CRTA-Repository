@extends('layouts.siteLayout')
@section('titulo','RETACE - Aprender')
@section('conteudo')
<div class="container card my-5">
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
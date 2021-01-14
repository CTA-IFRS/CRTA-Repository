@extends('layouts.siteLayout')
@section('titulo','RETACE - Aprender')
@section('conteudo')
<div class="container card my-5">
	<div class="row">
        <div class="col-12">
            <div class="row">
                <h1 class="display-3 pl-4">Aprender</h1>
            </div>
            <div class="row">
                <p class="lead pl-4">Acesse materiais para estudar mais sobre Tecnologias Assistivas</p> 
            </div>
        </div>
		<div id="conteudo" class="col-12 pt-5 pl-5" >
			<h1 class="display-4">
				{!! html_entity_decode(stripslashes($conteudoPagina->titulo_texto), ENT_QUOTES, 'UTF-8')!!} 
			</h1>
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
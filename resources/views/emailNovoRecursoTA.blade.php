@extends('layouts.siteLayout')
@section('titulo','RETACE - Nova Tecologia Assistiva Cadastrada')
@section('conteudo')
<div class="container card my-5">
	<div class="row">
        <div class="col-12">
            <div class="row">
                <h1 class="display-3 pl-4">Sobre</h1>
            </div>
            <div class="row">
                <p class="lead pl-4">Novo Recurso de Tecnologia Assistiva Cadastrado</p> 
            </div>
        </div>
		<div id="conteudo" class="col-12 pt-5 pl-5" >
			<p> O recurso {{-- $tituloRecurso --}} foi cadastrado no RETACE por um visitante. Acesse o Painel do Administrador em {{--url(/revisarRecursoTA/).$idRecurso--}} para revisar as informações inseridas e publicar a tecnologia assistiva no
			repositório </p>
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
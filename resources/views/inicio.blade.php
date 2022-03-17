@extends('layouts.siteLayout')

@section('titulo','RETACE - Repositório de Tecnologia Assistiva no Contexto Educacional - Início')

@section('bannerTelaInicial')
	@include('layouts.bannerTelaInicial')
@endsection
@section('conteudo')
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<h2>Recursos mais vistos</h2>
			</div>
		</div>
	</div>
	@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisAcessados ])
	<div class="contaier mt-5 p-5 bg-primary text-light contribute-strip">
		<div class="row">
			<div class="offset-md-1 col-md-2">
				<i class="fa fa-desktop fa-5x align-middle"></i>
				<i class="ml-2 fa fa-book fa-5x"></i>
			</div>
			<div id="aprender" class="col-md-3">
				<h3><a href="{{ url('/aprender')}}" class="text-white"> <u>Aprender</u> </a> </h3>
				<p> Acesse cursos, artigos, publicações e outros materiais relacionados à inclusão e tecnologia assistiva </p>
			</div>
			<div class="offset-md-1 col-md-2">
				<i class="ml-3 fa fa-pencil fa-5x align-baseline"></i>
				<i class="ml-3 fa fa-info-circle fa-5x align-middle"></i>
			</div>
			<div class="col-md-3">
				<h3> <a href="{{ url('/cadastrarTA')}}" class="text-white"> <u> Contribuir </u></a> </h3>
				<p> Disponibilize neste repositório seu recurso de TA, metodologia, material pedagógico acessível e outros </p>
			</div>
		</div>
	</div>
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<h2>Recursos mais recentes</h2>
			</div>
		</div>
	</div>
	@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisRecentes ])
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
	});
</script>
@endsection
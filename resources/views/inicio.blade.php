@extends('layouts.siteLayout')

@section('titulo','RETACE - Repositório de Tecnologia Assistiva no Contexto Educacional - Início')

@section('bannerTelaInicial')
	@include('layouts.bannerTelaInicial')
@endsection
@section('conteudo')
	<div class="container categorias_inicial mt-5">
		<div class="row">
			<div class="col-12">
				@include('layouts.categorias')
			</div>
			<div class="col-12 mt-5">
				<h2 class="text-center">Recursos mais vistos</h2>
			</div>
		</div>
	</div>
	@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisAcessados ])
	<div class="contaier mt-5 contribute-strip row" id="aprender_contribuir">
		<div id="aprender" class="bg-blue">
			<h3><a href="{{ url('/aprender')}}"> <u>Aprender</u> </a> </h3>
			<p> Acesse cursos, artigos, publicações e outros materiais relacionados à inclusão e tecnologia assistiva </p>
		</div>
		<div id="contribuir" class="bg-blue">
			<h3> <a href="{{ route('cadastrarTA')}}"> <u> Contribuir </u></a> </h3>
			<p> Disponibilize neste repositório seu recurso de TA, metodologia, material pedagógico acessível e outros </p>
		</div>
	</div>
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Recursos mais recentes</h2>
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
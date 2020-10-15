@extends('layouts.siteLayout')

@section('titulo','RETACE Início')

@section('bannerTelaInicial')
	@include('layouts.bannerTelaInicial')
@endsection
@section('conteudo')
	<h1 class="m-5">Recursos mais vistos</h1>
	@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisAcessados ])
	<div class="contaier mt-5 p-5 bg-primary text-light">
		<div class="row">
			<div class="offset-md-1 col-md-2">
				<i class="fa fa-desktop fa-5x align-middle"></i>
				<i class="ml-2 fa fa-book fa-5x"></i>
			</div>
			<div class="col-md-3">
				<h3> Aprender </h3>
				<p> Acesse cursos, artigos, publicações e outros materiais relacionados à inclusão e tecnologia assistiva </p>
			</div>
			<div class="offset-md-1 col-md-2">
				<i class="ml-3 fa fa-pencil fa-5x align-baseline"></i>
				<i class="ml-3 fa fa-info-circle fa-5x align-middle"></i>
			</div>
			<div class="col-md-3">
				<h3> Contribuir </h3>
				<p> Disponibilize neste repositório seu recurso de TA, metodologia, material pedagógico acessível e outros </p>
			</div>
		</div>
	</div>
	<h1 class="m-5">Recursos mais recentes</h1>
	@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisRecentes ])
@endsection
@section('scripts')
@endsection
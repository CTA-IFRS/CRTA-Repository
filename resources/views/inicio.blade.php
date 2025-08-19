@extends('layouts.siteLayout')

@section('titulo','RETACE - Repositório de Tecnologia Assistiva no Contexto Educacional - Início')

@section('bannerTelaInicial')
	@include('layouts.bannerTelaInicial')
@endsection
@section('conteudo')
	<div class="container-xl categorias_inicial mt-5">
		<div class="row">
			<div class="col-12 d-flex justify-content-center">
				@include('layouts.categorias')
			</div>
		</div>
	</div>
	<div class="container cardsInicial mt-5">
		<div class="row">
			<div class="col-12 d-flex flex-column">
				<h2 class="text-center d-flex flex-row align-items-center justify-content-center"><span class="destaqueTitulo"></span>Recursos mais recentes<span class="destaqueTitulo"></span></h2>
				<div class="mt-4">
    				<div class="listagem_recursos_sem_paginacao row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-5 p-0">
					@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisRecentes ])
					</div>
				</div>
				<a class="btn btn-secondary bg-transparent" href="{{ route('filtroTag', ['tecnologia assistiva']) }}">Ver mais <span class="sr-only">recursos de tecnologia assistiva</span><i class="fa fa-chevron-right mr-1" aria-hidden="true" style="margin-left: 12px;font-size: 16px;"></i></a>
			</div>
		</div>
	</div>
	<div class="contaier mt-5 contribute-strip row" id="aprender_contribuir">
		<div id="aprender" class="bg-blue my-4">
			<h3><a href="{{ url('/aprender')}}"> <u>Aprender</u> </a> </h3>
			<p>Acesse cursos e publicações relacionados à tecnologia assistiva no contexto educacional.</p>
		</div>
		<div id="contribuir" class="bg-blue my-4">
			<h3> <a href="{{ route('cadastrarTA')}}"> <u> Contribuir </u></a> </h3>
			<p>Disponibilize no RETACE seu recurso de tecnologia assistiva ou material pedagógico acessível.</p>
		</div>
	</div>
	<div class="container cardsInicial mt-5 mb-5">
		<div class="row">
			<div class="col-12 d-flex flex-column">
				<h2 class="text-center d-flex flex-row align-items-center justify-content-center"><span class="destaqueTitulo"></span>Recursos mais vistos<span class="destaqueTitulo"></span></h2>
				<div class="mt-4">
    				<div class="listagem_recursos_sem_paginacao row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-5 p-0">
					@include('layouts.listaCardsRecursosSemPaginacao',['recursosTA' => $recursosMaisAcessados ])
					</div>
				</div>
				<a class="btn btn-secondary bg-transparent" href="{{ route('filtroTag', ['tecnologia assistiva']) }}">Ver mais <span class="sr-only">recursos de tecnologia assistiva</span><i class="fa fa-chevron-right mr-1" aria-hidden="true" style="margin-left: 12px;font-size: 16px;"></i></a>
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
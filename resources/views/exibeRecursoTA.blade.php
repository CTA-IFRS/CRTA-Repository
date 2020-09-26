@extends('layouts.siteLayout')
@section('titulo','RETACE')
@section('conteudo')
<div class="container mt-5">
	<div class="row">
		<div id="fotosDescricao" class="card col-md-8 px-5 py-3" >
			<h1 class="my-1">
				{{ __($recursoTA->titulo) }}
			</h1>
			<ul id="galeria">
				@foreach($recursoTA->fotos as $foto)
				<li data-thumb="{{Storage::url('public/'.$foto->caminho_thumbnail)}}" data-src="{{Storage::url('public/'.$foto->caminho_arquivo)}}">
					<img class="fotoSelecionada" src="{{Storage::url('public/'.$foto->caminho_arquivo)}}" alt="{{$foto->texto_alternativo}}"/>
				</li>
				@endforeach			
			</ul>
			<div class="my-3">
				<h2 class="my-3">Descrição do Recurso</h2>
				<p class="h5 text-justify">{{ __($recursoTA->descricao) }}</p>				
			</div>		
		</div>
		<div id="colunaDireita" class="card offset-md-1 col-md-3">
			<div id="indicadores" class="row d-flex align-items-center justify-content-center text-center mt-4">
				<div id="avalicao" class="col-md-6">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</div>
				<div id="acessos" class="col-md-6">
					<i class="fa fa-eye" aria-hidden="true"></i>
					<span> Visitado 42 vezes</span>	
				</div>
				<hr class="col-md-10"/>
			</div>
			<div id="manuais" class="row mt-3">
				<h5 class="ml-2"> Manuais </h5>
				@foreach($recursoTA->manuais as $manual)
				<div class="col-md-10">
					<a href="{{__($manual->url)}}">{{__($manual->nome)}}</a>
				</div>
				<div class="col-md-6">
					<span>Formato: {{__($manual->formato)}}</span>
				</div>
				<div class="col-md-6">
					<span>Tamanho: {{__($manual->tamanho)}} Mb</span>
				</div>
				<hr class="col-md-10"/>
				@endforeach	
			</div>
			<div id="arquivos" class="row mt-3">
				<h5 class="ml-2"> Arquivos </h5>
				@foreach($recursoTA->arquivos as $arquivo)
				<div class="col-md-10">
					<a href="{{__($arquivo->url)}}">{{__($arquivo->nome)}}</a>
				</div>
				<div class="col-md-6">
					<span>Formato: {{__($arquivo->formato)}}</span>
				</div>
				<div class="col-md-6">
					<span>Tamanho: {{__($arquivo->tamanho)}} Mb</span>
				</div>
				<hr class="col-md-10"/>
				@endforeach	
			</div>
			<div id="fabricante" class="row mt-3">
				<h5 class="ml-2"> Fabricante </h5>
				<div class="col-md-10">
					<a href="{{__($recursoTA->site_fabricante)}}">{{__($recursoTA->site_fabricante)}}</a>
				</div>			
				<div class="col-md-10">
					@if($recursoTA->produto_comercial)
					<span> Produto comercial sob a licença {{__($recursoTA->licenca)}}</span>
					@else
					<span> Produto não comercial</span>
					@endif
				</div>		
			</div>
			<div id="publicacaoAutorizada" class="row">
				<div class="col-md-10 mt-3">
					@if($recursoTA->publicacao_autorizada)
					<span> Publicação autorizada</span>
					@else
					<span class="text-danger"> Publicação não autorizada</span>
					@endif
				</div>	
			</div>
		</div>			
	</div>
	<div id="recursosRelacionados" class="card col-md-12 my-5">
		<h1 class="my-3">Recursos Relacionados</h1>
		@include('listaCardsRecursos')
	</div>
</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
		$('#galeria').lightSlider({
			gallery:true,
			item:1,
			loop:false,
			slideMargin:0,
			enableDrag: false,
			currentPagerPosition:'left',
			pager: true,
			keyPress: true,
			addClass: "h-20 cursor-pointer",
			thumbItem: 5,
			onSliderLoad: function(el) {
				el.lightGallery({
					selector: '#galeria .lslide'
				});
			}   
		});  
	});
</script>
@endsection
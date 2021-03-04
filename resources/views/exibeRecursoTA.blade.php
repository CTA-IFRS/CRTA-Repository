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
					<img class="fotoSelecionada img-fluid" src="{{Storage::url('public/'.$foto->caminho_arquivo)}}" alt="{{$foto->texto_alternativo}}"/>
				</li>
				@endforeach
				@foreach($informacoesVideos as $infoVideo)
				<li class="hasVideo embed-responsive embed-responsive-4by3" data-src="{{$infoVideo->image}}"data-thumb="{{$infoVideo->image}}" data-iframe="{{$infoVideo->url}}">
					{!! html_entity_decode($infoVideo->code) !!}
				</li>
				@endforeach				
			</ul>
			<div class="my-3">
				<h2 class="my-3">Descrição do Recurso</h2>

				<div>{!! html_entity_decode(stripslashes($recursoTA->descricao), ENT_QUOTES, 'UTF-8')!!}</div>				
			</div>		
		</div>
		<div id="colunaDireita" class="card offset-md-1 col-md-3">
			<div id="indicadores" class="row d-flex align-items-center justify-content-center text-center mt-4">
				<div id="avaliacoes" class="col-md-6">					
					<input id="avaliacaoMediaRecurso" name="avaliacaoMediaRecurso" value="{{$mediaAvaliacao}}" class="rating-loading">				
				</div>
				<div id="acessos" class="col-md-6">
					<i class="fa fa-eye" aria-hidden="true"></i>
					<span> Visitado {{$recursoTA->visualizacoes}} vezes</span>	
				</div>
				<hr class="col-md-10"/>
			</div>
			<div id="manuais" class="row mt-3">
				<h5 class="ml-3 w-100"> Manuais </h5>
				<div class="ml-4">
					@if(sizeof($recursoTA->manuais)!=0)
					@foreach($recursoTA->manuais as $manual)
					<div class="col-md-12">
						<a href="{{__($manual->url)}}">{{__($manual->nome)}}</a>
					</div>
					<div class="col-md-12">
						<span>Formato: {{__($manual->formato)}}</span>
					</div>
					<div class="col-md-12">
						<span>Tamanho: {{__($manual->tamanho)}} Mb</span>
					</div>
					<hr class="col-md-10"/>
					@endforeach	
					@else
					<span> Não há manuais associados ao recurso</span>
					@endif
				</div>				
			</div>
			<div id="arquivos" class="row mt-3">
				<h5 class="ml-3 w-100"> Arquivos </h5>
				<div class="ml-4">
					@if(sizeof($recursoTA->arquivos)!=0)
					@foreach($recursoTA->arquivos as $arquivo)
					<div class="col-md-12">
						<a href="{{__($arquivo->url)}}">{{__($arquivo->nome)}}</a>
					</div>
					<div class="col-md-12">
						<span>Formato: {{__($arquivo->formato)}}</span>
					</div>
					<div class="col-md-12">
						<span>Tamanho: {{__($arquivo->tamanho)}} Mb</span>
					</div>
					<hr class="col-md-10"/>
					@endforeach
					@else
					<span> Não há arquivos associados ao recurso</span>
					@endif
				</div>	
			</div>
			<div id="fabricante" class="row mt-3">
				<h5 class="ml-3 w-100"> Fabricante </h5>
				<div class="ml-4">
					<div class="col-md-12">
						<a class="text-break" href="{{__($recursoTA->site_fabricante)}}">{{__($recursoTA->site_fabricante)}}</a>
					</div>			
					<div class="col-md-12">
						@if($recursoTA->produto_comercial)
						<span class="text-break"> Produto comercial sob a licença {{__($recursoTA->licenca)}}</span>
						@else
						<span> Produto não comercial</span>
						@endif
					</div>
				</div>		
			</div>
			<div id="tags" class="row mt-5">
				<div class="col-md-12 ml-4">
					@if(sizeof($recursoTA->tags))
					@foreach($recursoTA->tags as $tag)
					<h4 class="d-inline-block"><a href="{{url('buscaRecursoTAPorTag/'.$tag->nome)}}" class="badge badge-primary">{{$tag->nome}}</a></h4>
					@endforeach	
					@else
					<span class="text-danger"> Recurso sem tags associadas</span>
					@endif
				</div>	
			</div>			
			<div id="avaliacaoPeloUsuario" class="row d-flex align-items-center justify-content-center text-center mt-4">
				<h5>Avalie o recurso</h5>
				<div class="col-md-6">
					<input id="avaliacaoUsuario" name="avaliacaoUsuario" value="0" class="rating-loading">				
				</div>
				<hr class="col-md-10"/>
			</div>			
		</div>			
	</div>
	<div id="recursosRelacionados" class="card col-md-12 my-5">
		<h1 class="my-3">Recursos Relacionados</h1>
		@include('layouts.listaCardsRecursosSemPaginacao')
	</div>
</div>
<!-- Modal -->
<div class="modal alert alert-success hide fade in" data-keyboard="false" data-backdrop="static" id="modalConfirmaAvaliacao">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Header -->
			<div class="modal-header">
				<h4 class="modal-title">Confirmar avaliação</h4>
			</div>
			<!-- Body -->
			<div class="modal-body">
				<p>Deseja confirmar a avaliação fornecida?</p>
			</div>
			<!-- Footer -->
			<div class="modal-footer">
				<a class="btn btn-primary" href="{{url('/')}}">Sim</a>
				<a class="btn btn-primary" data-dismiss="modal" onclick="desmarcaAvaliacaoDada()">Não</a>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>

	$(document).ready(function() {

		$('#avaliacaoMediaRecurso').rating({
			displayOnly: true, 
			language: "pt-BR",
			theme: "krajee-fa",
			size: "sm"
		});

		$('#avaliacaoUsuario').rating({
			language: "pt-BR",
			theme: "krajee-fa",
			size: "sm",
			step: "1"
		});

		$("#avaliacaoUsuario").rating().on("rating:clear", function(event) {
			alert("Avaliação cancelada")
		}).on("rating:change", function(event, value, caption) {
			if(confirm("Deseja avaliar esse recurso como " + value + " estrelas?")){
				$(this).rating('refresh',{displayOnly:true});
			}else{
				$(this).rating('reset');
			}
		});

		$('input[name=avaliacao]').click(function(){
			$("#modalConfirmaAvaliacao").modal("show");
		});

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

		$('.video-stream').addClass("embed-responsive-item");
	});
</script>
@endsection
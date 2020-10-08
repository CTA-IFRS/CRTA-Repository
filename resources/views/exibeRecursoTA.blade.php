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
				@foreach($informacoesVideos as $infoVideo)
				<li class="hasVideo embed-responsive embed-responsive-4by3" data-src="{{$infoVideo->image}}"data-thumb="{{$infoVideo->image}}" data-iframe="{{$infoVideo->url}}">
					{{!! html_entity_decode($infoVideo->code->html) !!}}
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
				<div id="avaliacoes" class="avaliacaoMedia col-md-6">					
					@for ($i = 0; $i < $mediaAvaliacao; $i++)
					<label>&starf;</label> 
					@endfor
					@for ($j = 0; $j < $complementoAvaliacao; $j++)
					<label>&star;</label> 
					@endfor					
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
						<a href="{{__($recursoTA->site_fabricante)}}">{{__($recursoTA->site_fabricante)}}</a>
					</div>			
					<div class="col-md-12">
						@if($recursoTA->produto_comercial)
						<span> Produto comercial sob a licença {{__($recursoTA->licenca)}}</span>
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
					@if($tag->publicacao_autorizada)
					<!-- TODO: após criar a funcionalidade de busca, colocar o link-->
					<h4 class="d-inline-block"><a href="{{url('buscaRecursoTA/'.$tag->nome)}}" class="badge badge-primary">{{$tag->nome}}</a></h4>
					@else
					<h4 class="d-inline-block"><a href="{{url('buscaRecursoTA/'.$tag->nome)}}" class="badge badge-danger">{{$tag->nome}}</a></h4>
					@endif
					@endforeach	
					@else
					<span class="text-danger"> Recurso sem tags associadas</span>
					@endif
				</div>	
			</div>			
			<div id="publicacaoAutorizada" class="row">
				<div class="col-md-12 mt-3">
					@if($recursoTA->publicacao_autorizada)
					<span> Publicação autorizada</span>
					@else
					<span class="text-danger"> Publicação não autorizada</span>
					@endif
				</div>	
			</div>
			<div id="avaliacaoPeloUsuario" class="row d-flex align-items-center justify-content-center text-center mt-4">
				<h5>Avalie o recurso</h5>
				<div class="rating col-md-6">
					<input type="radio" name="avaliacao" value="5" id="5">
					<label for="5">☆</label> 
					<input type="radio" name="avaliacao" value="4" id="4">
					<label for="4">☆</label>
					<input type="radio" name="avaliacao" value="3" id="3">
					<label for="3">☆</label>
					<input type="radio" name="avaliacao" value="2" id="2">
					<label for="2">☆</label>
					<input type="radio" name="avaliacao" value="1" id="1">
					<label for="1">☆</label>					
				</div>
				<hr class="col-md-10"/>
			</div>			
		</div>			
	</div>
	<div id="recursosRelacionados" class="card col-md-12 my-5">
		<h1 class="my-3">Recursos Relacionados</h1>
		@include('recursosRelacionados')
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
	function desmarcaAvaliacaoDada(){
		$('#avaliacaoPeloUsuario').closest('div').find('label').each(function(){
			$(this).text($(this).text().replace("&starf;","&star;"));
		}); 	
	}

	$(document).ready(function() {

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
	});
</script>
@endsection
@extends('adminlte::page')

@section('title', 'Painel do Administrador - Revisar Publicação')

@section('content_header')
<h1 class="display-3">Revisão para Publicação de Recurso de Tecnologia Assistiva</h1>
<p class="mt-3 ml-2"> Revise abaixo os dados cadastrados para o recurso, marcando os itens que estão em conformidade com o esperado</p>
@stop

@section('content')
<div id="app" class="container">
	<div class="row">
		<div class="col-12">
			<b>Título</b>
		</div>
		<div class="col-12">
			{{__($recursoTA->titulo)}}
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12">
			<b>Descrição</b>
		</div>
		<div class="col-12">
			{{__($recursoTA->descricao)}}
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12">
			<b>Fabricante</b>
		</div>
		<div class="col-12">
			<a href="{{__($recursoTA->site_fabricante)}}">{{__($recursoTA->site_fabricante)}}</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12"> 
			<b>É produto comercial?</b> 
		</div>
		<div class="col-12">
			@if($recursoTA->produto_comercial==true)
			<span class="badge badge-pill badge-success">Sim</span>
			@else
			<span class="badge badge-pill badge-warning">Não</span>
			@endif
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12">
			<b>Tags</b>
			<small>Tags não autorizadas aparecerão em vermelho e só aparecerão aos usuários após moderação por um administrador</small>
		</div>
		<div class="col-12">
			@foreach($recursoTA->tags as $tag)
			@if($tag->publicacao_autorizada==true)
			<span class="badge badge-pill badge-primary">{{__($tag->nome)}}</span>
			@else
			<span class="badge badge-pill badge-danger">{{__($tag->nome)}}</span>
			@endif
			@endforeach
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12"> 
			<b>Manuais</b> 
		</div>
		<div class="col-12">
			@foreach($recursoTA->manuais as $manual)
			<div class="card">
				<div class="card-header">
					{{__($manual->nome)}}
				</div>
				<div class="card-body" style="overflow-x: auto;">
					<h5 class="card-title">
						<a href="{{__($manual->url)}}" target="_blank">{{__($manual->url)}}</a>
					</h5>
					<p class="card-text">Tamanho: {{__($manual->tamanho)}} mb</p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12"> 
			<b>Arquivos</b> 
		</div>
		<div class="col-12">
			@foreach($recursoTA->arquivos as $arquivo)
			<div class="card">
				<div class="card-header">
					{{__($arquivo->nome)}}
				</div>
				<div class="card-body" style="overflow-x: auto;">
					<h5 class="card-title">
						<a href="{{__($arquivo->url)}}" target="_blank">{{__($arquivo->url)}}</a>
					</h5>
					<p class="card-text">Tamanho: {{__($arquivo->tamanho)}} mb</p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-12"> 
			<b>Galeria de Fotos e Vídeos</b>
			<small>Clique para abrir a galeria e ler o texto alternativo</small>
		</div>
		<div class="col-12">
			<ul id="galeria">
				@foreach($recursoTA->fotos as $foto)
				<li data-thumb="{{Storage::url('public/'.$foto->caminho_thumbnail)}}" data-src="{{Storage::url('public/'.$foto->caminho_arquivo)}}">
					<img class="fotoSelecionada img-fluid" src="{{Storage::url('public/'.$foto->caminho_arquivo)}}" alt="{{$foto->texto_alternativo}}"/>
				</li>
				@endforeach
				@foreach($informacoesVideos as $infoVideo)
				<li class="hasVideo embed-responsive-4by3" data-src="{{$infoVideo->image}}"data-thumb="{{$infoVideo->image}}" data-iframe="{{$infoVideo->url}}">
					{!! html_entity_decode($infoVideo->code->html) !!}
				</li>
				@endforeach				
			</ul>
		</div>
	</div>
	<hr>
	<div class="row py-4">
		<div class="col-12 pb-2"> <b>Ações</b> </div>
		<div class="col-2">
			<a href="{{url('/administrarRecursosTA')}}" class="btn btn-primary"><b>Voltar</b></a>
		</div>
		<div class="offset-5 col-2">
			<a id="btnAutorizar" href="{{url('/autorizarPublicacaoRecursoTA/'.$recursoTA->id)}}" class="btn btn-success"><b>Publicar</b></a>
		</div>
		<div class="col-3"	>
			<a id="btnRejeitar" href="{{url('/rejeitarPublicacaoRecursoTA/'.$recursoTA->id)}}" class="btn btn-danger"><b>Rejeitar</b></a>
		</div>
	</div>
</div>
@stop

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript">
	$("#btnAutorizar").click(function(){
		if(confirm("Deseja disponibilizar esse recurso aos usuários do RETACE?")){
			return true;
		}	
		else{
			return false;
		}
	});

	$("#btnRejeitar").click(function(){
		if(confirm("Deseja rejeitar o recurso? Ele permanecerá no banco de dados, mas não será visível aos usuários do RETACE")){
			return true;
		}	
		else{
			return false;
		}
	});

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

		$('.video-stream').addClass("embed-responsive-item");
	} );
</script>
@stop
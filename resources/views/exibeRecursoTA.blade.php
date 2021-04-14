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
				<li data-thumb="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" data-src="{{url(Storage::url('public/'.$foto->caminho_arquivo))}}">
					<img class="fotoSelecionada img-fluid" src="{{url(Storage::url('public/'.$foto->caminho_arquivo))}}" alt="{{$foto->texto_alternativo}}"/>
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
					<input id="avaliacaoMediaRecurso" name="avaliacaoMediaRecurso" value="{{$mediaAvaliacao}}" 
						class="rating-loading" aria-label="Avaliação média do recurso">				
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
						<a href="{{__($manual->url)}}">{{$manual->nome}}</a>
					</div>
					<div class="col-md-12">
						<span>Formato: {{$manual->formato}}</span>
					</div>
					<div class="col-md-12">
						<span>Tamanho: {{$manual->tamanho}} Mb</span>
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
						<a href="{{__($arquivo->url)}}">{{$arquivo->nome}}</a>
					</div>
					<div class="col-md-12">
						<span>Formato: {{$arquivo->formato}}</span>
					</div>
					<div class="col-md-12">
						<span>Tamanho: {{$arquivo->tamanho}} Mb</span>
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
						<a class="text-break" href="{{__($recursoTA->site_fabricante)}}">{{$recursoTA->site_fabricante}}</a>
					</div>			
					<div class="col-md-12">
						@if($recursoTA->produto_comercial)
						<span class="text-break"> Produto comercial sob a licença {{$recursoTA->licenca}}</span>
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
				@if(Cookie::get('avaliouRecursoTA_'.$recursoTA->id)==null)	
				<h5 id="label-avaliacaoUsuario">Avalie o recurso</h5>		
				<div class="col-md-6">
					<input id="avaliacaoUsuario" name="avaliacaoUsuario" value="0" class="rating-loading" 
						aria-labelledby="label-avaliacaoUsuario" tabindex="-1">
					<div class="sr-only">
						<select id="avaliacaoUsuario-sr" aria-labelledby="label-avaliacaoUsuario">
							<option value="0">Não avaliado</option>
							<option value="1">Uma estrela</option>
							<option value="2">Duas estrelas</option>
							<option value="3">Três estrelas</option>
							<option value="4">Quatro estrelas</option>
							<option value="5">Cinco estrelas</option>
						</select>		
						<button id="enviarAvaliacaoUsuario-sr" type="button">Enviar avaliação</button>		
					</div>
				</div>
				@else
				<h5 class="text-success">Recurso já avaliado</h5>
				@endif			
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

		$("#enviarAvaliacaoUsuario-sr").on("click", function (event) {
			var avalUsuarioSr = $("#avaliacaoUsuario-sr");
			var value = avalUsuarioSr.val();
			if (value != 0) {
				$("#avaliacaoUsuario")
					.rating("update", value)
					.trigger("rating:change", value, avalUsuarioSr.text());
			}
		});

		$("#avaliacaoUsuario").rating().on("rating:clear", function(event) {
			alert("Avaliação cancelada")
		}).on("rating:change", function(event, value, caption) {
			if(confirm("Deseja avaliar esse recurso como " + value + " estrelas?")){
				$.ajax({
					method: "POST",
					url: "{{route('avaliarRecursoTA')}}",
					data: { "_token": "{{ csrf_token() }}",
							nota: value,
							idRecurso: {{$recursoTA->id}} },
					success: function(resposta){
						$('#avaliacaoUsuario').rating('refresh',{displayOnly:true});
						$('#avaliacaoMediaRecurso').rating('refresh',{displayOnly:true,value:resposta[1]});
						alert(resposta[0]);
					},
					error: function(resposta){
						alert(resposta[0]);
					}
				});
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
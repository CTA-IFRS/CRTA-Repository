@extends('layouts.siteLayout')
@section('titulo','RETACE')
@section('conteudo')
<div class="container mt-5">
	<div class="row">
		<div id="fotosDescricao" class="card col-md-8 px-5 py-3" >
			<h1 class="my-1">
				{{ __($recursoTA->titulo) }}
			</h1>
			<a href="#fim-galeria" id="inicio-galeria" class="sr-only">Início da galeria de imagens do recurso, clique para pular</a>
			<ul id="galeria">
				@foreach($recursoTA->fotos as $foto)
				<li data-thumb="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" data-src="{{url(Storage::url('public/'.$foto->caminho_arquivo))}}">
					<a href="#">
						<img class="fotoSelecionada img-fluid" src="{{url(Storage::url('public/'.$foto->caminho_arquivo))}}" alt="{{$foto->texto_alternativo}}"/>
					</a>
				</li>
				@endforeach
				@foreach($informacoesVideos as $infoVideo)
				<li class="hasVideo embed-responsive embed-responsive-4by3" data-src="{{$infoVideo->image}}" data-thumb="{{$infoVideo->image}}" data-iframe="{{$infoVideo->url}}">
					<?php $uniqueId = uniqid(""); ?>
					<a href="#fim-video-{{$uniqueId}}" id="inicio-video-{{$uniqueId}}" 
						class="sr-only ignore-click-eff">Início do vídeo "{{$infoVideo->title}}", clique para pular o vídeo
					</a>

						{!! html_entity_decode($infoVideo->code) !!}
						
					<a href="#inicio-video-{{$uniqueId}}" id="fim-video-{{$uniqueId}}" class="sr-only ignore-click-eff">
						Fim do vídeo "{{$infoVideo->title}}", clique para voltar ao início
					</a>
				</li>
				@endforeach				
			</ul>
			<a href="#inicio-galeria" id="fim-galeria" class="sr-only">Final da galeria de imagens do recurso, clique para voltar ao início</a>

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
			<div id="tags" class="row mt-4">
				<h5 class="ml-3 w-100"> Tags </h5>
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
					<div id="formAvaliacao-sr" class="sr-only">
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
				<p id="agradecimento-avaliacao" tabindex="-1" class="h5 text-success d-none">Agradecemos sua avaliação</p>
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
<div class="modal alert alert-success hide fade in" tabindex="-1" role="dialog" data-keyboard="false" 
	data-backdrop="static" id="modalConfirmaAvaliacao">
	<div class="modal-dialog" role="document">
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
				<button type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	function showConfirmMessage(msg, title, f_yes, f_no) {
		$("#modalConfirmaAvaliacao .modal-title").first().text(title);
		$("#modalConfirmaAvaliacao .modal-body").first().text(msg);
		$("#modalConfirmaAvaliacao .modal-footer button").first().on("click", function (ev) {
			if (f_yes) f_yes();
		});
		$("#modalConfirmaAvaliacao .modal-footer button").last().on("click", function (ev) {
			if (f_no) f_no();
		});
		$("#modalConfirmaAvaliacao").modal("show");
		$("#modalConfirmaAvaliacao").focus();
	}

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
			var self = this;
			showConfirmMessage("Confirmar avaliação", 
				"Deseja avaliar esse recurso como " + value + " estrelas?",
				function () {
					$.ajax({
						method: "POST",
						url: "{{route('avaliarRecursoTA')}}",
						data: { "_token": "{{ csrf_token() }}",
								nota: value,
								idRecurso: {{$recursoTA->id}} },
						success: function(resposta){
							$('#avaliacaoUsuario').rating('refresh',{displayOnly:true});
							$('#avaliacaoMediaRecurso').rating('refresh',{displayOnly:true,value:resposta[1]});
							$('#formAvaliacao-sr').hide();
							$('#agradecimento-avaliacao').removeClass('d-none');
							$('#agradecimento-avaliacao').focus();
						},
						error: function(resposta){
							alert(resposta[0]);
						}
					});
				}, 
				function () {
					$(self).rating('reset');
					$("#enviarAvaliacaoUsuario-sr").focus();
				}
			);
		});

		$('input[name=avaliacao]').click(function(){
			$("#modalConfirmaAvaliacao").modal("show");
		});

		var slider = $('#galeria').lightSlider({
			gallery:true,
			item:1,
			loop:false,
			slideMargin:0,
			enableDrag: false,
			currentPagerPosition:'left',
			keyPress: false,
			addClass: "h-20 cursor-pointer",
			thumbItem: 5,
			onSliderLoad: function(el) {
				el.lightGallery();

				$("a.ignore-click-eff").on("click", function (event) {
					var elemId = $(this).attr("href");
					$(elemId).focus();
					return false;
				});

				var f_RemoveThumbLinksFromTabSequence = function () {
					$('ul[class~="lSPager"] a')
						.attr("tabindex", "-1").prop("tabindex", "-1")
						.attr("aria-hidden", "true").prop("aria-hidden", "true");
				};

				f_RemoveThumbLinksFromTabSequence();
				var observer = new MutationObserver(function (mutations) {
					f_RemoveThumbLinksFromTabSequence();
				});
				observer.observe($('ul[class~="lSPager"]').get(0), {subtree: true, childList:true});
			}   
		});
		
		$('.video-stream').addClass("embed-responsive-item");
		
	});
</script>
@endsection
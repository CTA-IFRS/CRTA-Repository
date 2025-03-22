@extends('layouts.siteLayout')
@section('titulo','RETACE')
@section('conteudo')
<div id="pagRecurso" class="container mt-5 custom_content">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
			['name' => 'Recursos'],
            ['name' => __($recursoTA->titulo), 'current' => true]
        ]
    ?>
    <div class="row breadcrumb-clear-pad">
        <div class="col">
            @include('layouts.breadcrumb', $data)
        </div>
    </div>
	<div id="tituloRecurso">
		<div class="p-3 p-sm-4 bg-white card row">
			<div class="row">
				<div class="col-12 col-md-10">
					<h2 class="my-1 h1">
						{{ __($recursoTA->titulo) }}
					</h2>
					<div id="avaliacoes">
						<input id="avaliacaoMediaRecurso" name="avaliacaoMediaRecurso" value="{{$mediaAvaliacao}}"  class="rating-loading" aria-label="Avaliação média do recurso">				
					</div>
				</div>
				<div id="acessos" class="col-12 col-md-2" style="height: fit-content;margin-top: auto;">
					<i class="fa fa-eye" aria-hidden="true"></i>
					<span> Visitado {{$recursoTA->visualizacoes}} vezes</span>	
				</div>
			</div>
		</div>
	</div>
	<div id="fotosRecurso">
		<div id="fotosDescricao" class="card col-md-12 px-5 py-3 bg-white">
			<a href="#fim-galeria" id="inicio-galeria" class="sr-only">Início da galeria de imagens e vídeos do recurso, clique para pular</a>
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
			<a href="#inicio-galeria" id="fim-galeria" class="sr-only">Final da galeria de imagens e vídeos do recurso, clique para voltar ao início</a>	
		</div>
	</div>
	<div class="row" id="DescricaoDetalhes">
		<div class="col col-md-8 col-12">
		<div id="colunaEsquerda" class="card p-3 p-sm-4">
				<h3 class="mb-3 h2">Descrição do Recurso</h3>
				<div>{!! $recursoTA->descricao !!}</div>
				<hr>
				<div id="tags" class="my-1">
					<h3 class="w-100 h5"> Tags </h3>
					<div class="col-md-12 p-0">
						<?php $tagsAprovadas = $recursoTA->tagsAprovadas() ?>
						@if(sizeof($tagsAprovadas) > 0)
						@foreach($tagsAprovadas as $tag)
						<h4 class="d-inline-block"><a href="{{route('filtroTag', $tag->nome)}}" class="badge badge-primary">{{$tag->nome}}</a></h4>
						@endforeach	
						@else
						<span class="text-danger"> Recurso sem tags associadas</span>
						@endif
					</div>	
				</div>
				<hr>
				<div id="avaliacaoPeloUsuario" class="d-flex align-items-center mt-1 flex-wrap" tabindex="0">
					@if(Cookie::get('avaliouRecursoTA_'.$recursoTA->id)==null)	
					<h3 id="label-avaliacaoUsuario" class="h5 m-0 pr-3">Avalie o recurso</h3>		
					<div>
						<input id="avaliacaoUsuario" name="avaliacaoUsuario" value="0" class="rating-loading" 
							aria-labelledby="label-avaliacaoUsuario" tabindex="-1">
						<div id="formAvaliacao-sr" class="sr-only mt-2">
							<select id="avaliacaoUsuario-sr" aria-labelledby="label-avaliacaoUsuario">
								<option value="0">Não avaliado</option>
								<option value="1">Uma estrela</option>
								<option value="2">Duas estrelas</option>
								<option value="3">Três estrelas</option>
								<option value="4">Quatro estrelas</option>
								<option value="5">Cinco estrelas</option>
							</select>	
							<button id="enviarAvaliacaoUsuario-sr" type="button" class="bg-primary">Enviar avaliação</button>		
						</div>
					</div>
					<p id="agradecimento-avaliacao" tabindex="-1" class="h5 text-success d-none text-center">Agradecemos sua avaliação</p>
					@else
					<h3 class="text-success h5">Recurso já avaliado</h3>
					@endif
				</div>
			</div>
		</div>
		<div class="col col-md-4 col-12">
		<div id="colunaDireita" class="card p-3 p-sm-4 mt-sm-4 mt-md-0 mt-4">
				<div id="manuais" class="row">
					<h3 class="ml-3 w-100 h5"> Manuais </h3>
					<div>
						@if(sizeof($recursoTA->manuais)!=0)
						@foreach($recursoTA->manuais as $manual)
							<div class="col-md-12">
								<a href="{{__($manual->url)}}">
									{{$manual->nome}}
									@if ($manual->formato && $manual->tamanho)
										(<span class="sr-only">Formato:</span> {{$manual->formato}}, 
										<span class="sr-only">Tamanho:</span> {{$manual->tamanho}} MB)
									@endif
									@if ($manual->link_externo)
										<span>(Link externo)</span>
									@endif
								</a>
							</div>
							<br>
						@endforeach	
						@else
						<div class="col-md-12">
							<span> Não há manuais associados ao recurso</span>
						</div>
						@endif
					</div>				
				</div>
				<div id="arquivos" class="row mt-3 mb-1">
					<h3 class="ml-3 w-100 h5"> Arquivos </h3>
					<div>
						@if(sizeof($recursoTA->arquivos)!=0)
							@foreach($recursoTA->arquivos as $arquivo)
							<div class="col-md-12">
								<a href="{{__($arquivo->url)}}">
									{{$arquivo->nome}}
									@if ($arquivo->formato && $arquivo->tamanho)
										(<span class="sr-only">Formato:</span> {{$arquivo->formato}},
										<span class="sr-only">Tamanho:</span> {{$arquivo->tamanho}} MB)
									@endif
									@if ($arquivo->link_externo)
										<span>(Link externo)</span>
									@endif
								</a>
							</div>
							<br>
							@endforeach
						@else
						<div class="col-md-12">
							<span> Não há arquivos associados ao recurso</span>
						</div>
						@endif
					</div>	
				</div>
				<hr/>
				<div id="fabricante" class="row mt-1">
					<h3 class="ml-3 w-100 h5"> Fabricante </h3>
					<div>
						<div class="col-md-12">
							@if ($recursoTA->site_fabricante)
								<a class="text-break" href="{{__($recursoTA->site_fabricante)}}">
									Página do recurso
								</a>
							@else
								<span>Site do recurso não informado</span>
							@endif
						</div>		
						<div class="col-md-12 mt-2">
							<span class="d-block"><b>Licença:</b> </span>
							@if($recursoTA->licenca)
							<span class="text-break"> Produto sob a licença {{$recursoTA->licenca}}</span>
							@else
							<span>Não informado</span>
							@endif
						</div>
					</div>		
				</div>
			</div>
		</div>
	</div>
	
	<div id="recursosRelacionados" class="card col-md-12 my-5 bg-transparent p-0">
		<h2 class="mt-3 text-center">Recursos Relacionados</h2>
		@include('layouts.listaCardsRecursosVertical')
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
		var buttons = $("#modalConfirmaAvaliacao .modal-footer button");
		buttons.first().on("click", function (ev) {
			if (f_yes) f_yes();
		});
		buttons.last().on("click", function (ev) {
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
			step: "1",
			clearButton: ""
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
				function () { //f_yes
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
							$('#agradecimento-avaliacao').addClass('mb-0 ml-2');
							$('#agradecimento-avaliacao').focus();
						},
						error: function(resposta){
							alert(resposta[0]);
						}
					});
				}, 
				function () { // f_no
					$(self).rating('reset');
					$("#enviarAvaliacaoUsuario-sr").focus();
				}
			);
		});

		$('input[name=avaliacao]').click(function(){
			$("#modalConfirmaAvaliacao").modal("show");
		});

		$('#galeria').lightSlider({
			gallery:true,
			adaptiveHeight: true,
			item:1,
			loop:false,
			slideMargin:0,
			enableDrag: false,
			currentPagerPosition:'left',
			pager: true,
			keyPress: false,
			addClass: "cursor-pointer",
			thumbItem: 5,
			onSliderLoad: function(el) {
				$("a.ignore-click-eff").on("click", function (event) {
					var elemId = $(this).attr("href");
					$(elemId).focus();
					return false;
				});

				var f_RemoveThumbLinksFromTabSequence = function () {
					$('ul[class~="lSPager"] a img')
						.attr("role", "presentation")
						.attr("aria-hidden", "true")
						.attr("alt", "Imagem...");
					$('ul[class~="lSPager"] a')
						.attr("tabindex", "-1")
						.attr("aria-hidden", "true")
						.attr("role", "presentation");	
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

	const formAvaliacao = document.getElementById('formAvaliacao-sr');
	   
	document.getElementById('avaliacaoPeloUsuario').addEventListener('focus', function() {
		if (event.target.matches(':focus-visible')) {
			formAvaliacao.classList.remove('sr-only');
		}
	});

</script>
@endsection



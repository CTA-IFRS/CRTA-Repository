@extends('adminlte::page')

@section('title', 'Painel do Administrador - Revisar Publicação')

@section('content_header')
<h1 class="display-3">Revisão para Publicação de Recurso de Tecnologia Assistiva</h1>
<p class="mt-3 ml-2"> Revise abaixo os dados cadastrados para o recurso, marcando os itens que estão em conformidade com o esperado</p>
@stop

@section('content')
<div class="container">
	<div id="alert-erros-formulario" tabindex="-1" class="alert alert-danger d-none">
		Por favor verifique o formulário novamente, alguns campos não foram preenchidos corretamente.
	</div>  
	<form id="revisaoRecursoTA" method="post" action="{{ route('editarRecursoTA', [ 'idRecursoTA' => $recursoTA->id]) }}" enctype="multipart/form-data">
		@csrf
		<fieldset>
			<legend class="h3">Informações básicas</legend>
			<div class="form-group required mt-3" role="group">
				<label for="titulo" class="text-md-right">
					{{ __('Título') }}
					<span class="sr-only">&nbsp;(Campo requerido)</span>
				</label>
				<div class="">
					<input id="titulo" type="text" class="form-control" name="titulo" value="{{ $recursoTA->titulo }}" autofocus>
				</div>
			</div>
			
			<div class="form-group required" role="group">
				<label for="descricao" id="descricao-label" class="text-md-right">
					{{ __('Breve descrição') }}
					<span class="sr-only">&nbsp;(Campo requerido)</span>
				</label>
				<div class="">
					<textarea class="form-control descricao" id="descricao" name="descricao" rows="8">{{$recursoTA->descricao}}</textarea>
				</div>
			</div>
			
			<fieldset class="form-group required">
				<div class="row">
					<legend class="col-form-label col-md-2 pt-0 text-md-left" id="label-legend-text">
						É um produto comercial?
						<span class="sr-only">&nbsp;(Campo requerido)</span>
						<div id="legend-label-produtoComercial" class="sr-only"></div>
					</legend>
					<div class="col-md-2">
						<label class="form-check-label pl-4">
							<input class="form-check-input" type="radio" id="comercial" name="produtoComercial" 
								value="true" aria-labelledby="label-legend-text label-sim"
								{{ $recursoTA->produto_comercial ? 'checked' : '' }}>
							<span id="label-sim">{{ __('Sim') }}</span>
						</label>
					</div>
					<div class="col-md-2">                            
						<label class="form-check-label">
							<input class="form-check-input" type="radio" id="naoComercial" name="produtoComercial" 
							value="false" aria-labelledby="label-legend-text label-nao"
							{{ $recursoTA->produto_comercial ? '' : 'checked' }}>
							<span id="label-nao">{{ __('Não') }}</span>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span id="produtoComercial"></span>
					</div>
				</div>
			</fieldset>

			<div class="form-group required">
				<label for="siteFabricante" class="text-md-right">
					{{ __('Site do fabricante') }}
					<span class="sr-only">&nbsp;(Campo requerido)</span>
				</label>
				<div class="">
					<input id="siteFabricante" type="text" class="form-control" name="siteFabricante" value="{{ $recursoTA->site_fabricante }}">
				</div>
			</div>
			
			<div id="divLicenca" class="form-group required d-none">
				<label for="licenca" class="text-md-right">
					{{ __('Licença') }}
					<span class="sr-only">&nbsp;(Campo requerido)</span>
				</label>
				<div class="">
					<input id="licenca" type="text" class="form-control" name="licenca" value="{{ $recursoTA->licenca }}">
				</div>
			</div>

			<div class="form-group required">
				<label for="tags" id="tags-label" class="text-md-right">
					{{ __('Tags') }}
					<span class="sr-only">&nbsp;(Campo requerido)</span>
				</label>
				<div class="">
					<input type="text" class="form-control" name="tags" id="tags" value="{{$tagsDoRecursoTA}}"/>
				</div>
			</div>
		</fieldset>

		<hr>
		<div id="status-adicao-links" class="sr-only" role="status"></div>


		<fieldset>
			<legend id="videos-label" class="mt-4 h3">Vídeos relacionados</legend>
			<p> Informe o endereço (url) de vídeos sobre a tecnologia assistiva</p>
			<div id="divVideos" class="form-group row" role="group" aria-labelledby="videos-label">
				<label for="urlVideo" class="col-md-2 col-form-label text-md-right">{{ __('Link para o vídeo') }}</label>
				<div class="col-md-10 form-inline">
					<input id="urlVideo" type="url"  class="w-75 form-control @error('videos[]') is-invalid @enderror" name="video" value="{{ old('video') }}">
					<button id="btnAdicionarVideo" type="button" class="w-25 btn btn-primary" aria-label="Adicionar o vídeo">
						<i class="fa fa-plus-square fa-1"></i>
					</button>
					@error('videos[]')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="offset-md-1 col-md-10 mt-4">
					<p>{{__('Vídeos a serem cadastrados para este recurso:')}}</p>
					<ul id="videos" class="list-group list-group-flush text-center">
						@if($recursoTA->videos->count()==0)
						<li id="avisoListaVazia-videos" class="list-group-item">Não serão adicionados vídeos</li>
						@else
						@foreach($recursoTA->videos as $video)
						<li class="list-group-item">
							<div class="card">
							<div class="card-body">
								<a href="{{$video->url}}" class="col-md-10">
								<span class="sr-only">Endereço do vídeo: </span>{{$video->url}}</a>
								<button type="button" aria-label="Remover vídeo" class="btn-remover-video btn btn-danger">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</button>
								<input name="videos[{{$contadorUrls}}][url]" class="form-control" type="hidden" value="{{$video->url}}"/>
							</div>
							</div>
						</li>
						@php ($contadorUrls++)
						@endforeach
						@endif
					</ul>
				</div>                        
			</div>
		</fieldset>

		<hr>

		<fieldset>
			<legend id="arquivos-label" class="mt-4 h3">Arquivos</legend>
			<p> Informe, se houver, endereços (url) para acessar arquivos relacionados ao recurso a ser cadastrado </p>
			<div id="divArquivos" class="form-group row" role="group" aria-labelledby="arquivos-label">
				<label for="urlArquivo" class="col-md-2 col-form-label text-md-right">{{ __('Link para o arquivo') }}</label>
				<div class="col-md-10 form-inline">
					<input id="urlArquivo" type="url"  class="w-75 form-control @error('arquivos[]') is-invalid @enderror" name="arquivo" value="{{ old('arquivo') }}">
					<button id="btnAdicionarArquivo" type="button" class="w-25 btn btn-primary" aria-label="Adicionar o arquivo">
						<i class="fa fa-plus-square fa-1"></i>
					</button>
					@error('arquivos[]')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="offset-md-1 col-md-10 mt-4">
					<p>{{__('Arquivos a serem cadastrados para este recurso:')}}</p>
					<ul id="arquivos" class="list-group list-group-flush text-center">
						@if($recursoTA->arquivos->count()==0)
						<li id="avisoListaVazia-arquivos" class="list-group-item">Não serão adicionados arquivos</li>
						@else
						@foreach($recursoTA->arquivos as $arquivo)
						<li class="list-group-item">
							<div class="card">
								<div class="card-body">
									<a class="col-md-10" href="{{$arquivo->url}}" class="mx-4">
									<span class="sr-only">Endereço do arquivo: </span>{{$arquivo->url}}</a>
									<button type="button" aria-label="Remover arquivo" class="btn-remover-arquivo btn btn-danger">
									<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
									<input name="arquivos[{{$contadorUrls}}][url]" class="form-control mt-2" type="hidden" value="{{$arquivo->url}}"/>
									<label for="nome-arquivo-{{$contadorUrls}}" class="form-group d-block"><span class="sr-only">Nome do arquivo</span>
									<input id="nome-arquivo-{{$contadorUrls}}" name="arquivos[{{$contadorUrls}}][nome]" class="form-control mt-2" 
											type="text" placeholder="Nome do arquivo" value="{{$arquivo->nome}}"/>
									</label>
									<label for="formato-arquivo-{{$contadorUrls}}" class="form-group d-block"><span class="sr-only">Formato do arquivo</span>
									<input id="formato-arquivo-{{$contadorUrls}}"name="arquivos[{{$contadorUrls}}][formato]" class="form-control mt-2" 
										type="text" placeholder="Formato/extensão do arquivo" value="{{$arquivo->formato}}"/>
									</label>
									<label for="tamanho-arquivo-{{$contadorUrls}}" class="form-group d-block"><span class="sr-only">Tamanho do arquivo</span>
									<input id="tamanho-arquivo-{{$contadorUrls}}" name="arquivos[{{$contadorUrls}}][tamanho]" class="form-control mt-2" 
										type="text" placeholder="Tamanho do arquivo (em Megabytes)" value="{{$arquivo->tamanho}}"/>
									</label>
								</div>
							</div>
						</li>
						@php ($contadorUrls++)
						@endforeach
						@endif					
					</ul>                            
				</div>                                          
			</div>
		</fieldset>		

		<hr>

		<fieldset>
			<legend id="manuais-label" class="mt-4 h3">Manuais</legend>
			<p> Informe, se houver, endereços (url) para acessar manuais relacionados ao recurso a ser cadastrado </p>
			<div id="divManuais" class="form-group row" role="group" aria-labelledby="manuais-label">
				<label for="urlManual" class="col-md-2 col-form-label text-md-right">{{ __('Link para o manual') }}</label>
				<div class="col-md-10 form-inline">
					<input id="urlManual" type="url"  class="w-75 form-control @error('manuais[]') is-invalid @enderror" name="manual" value="{{ old('manual') }}">
					<button id="btnAdicionarManual" type="button" class="w-25 btn btn-primary" aria-label="Adicionar o manual">
						<i class="fa fa-plus-square fa-1"></i>
					</button>
					@error('manuais[]')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="offset-md-1 col-md-10 mt-4">
					<p>{{__('Manuais a serem cadastrados para este recurso:')}}</p>
					<ul id="manuais" class="list-group list-group-flush text-center">
						@if($recursoTA->manuais->count()==0)
						<li id="avisoListaVazia-manuais" class="list-group-item">Não serão adicionados manuais</li>
						@else
						@foreach($recursoTA->manuais as $manual)
						<li class="list-group-item">
							<div class="card">
								<div class="card-body">
									<a class="col-md-10" href="{{$manual->url}}" class="mx-4">
									<span class="sr-only">Endereço do arquivo: </span>{{$manual->url}}</a>
									<button type="button" aria-label="Remover manual" class="btn-remover-manual btn btn-danger">
									<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
									<input name="manuais[{{$contadorUrls}}][url]" class="form-control mt-2" type="hidden" value="{{$manual->url}}"/>
									<label for="nome-manual-{{$contadorUrls}}" class="form-group d-block"><span class="sr-only">Nome do arquivo</span>
									<input id="nome-manual-{{$contadorUrls}}" name="manuais[{{$contadorUrls}}][nome]" class="form-control mt-2" 
											type="text" placeholder="Nome do arquivo" value="{{$manual->nome}}"/>
									</label>
									<label for="formato-manual-{{$contadorUrls}}" class="form-group d-block"><span class="sr-only">Formato do arquivo</span>
									<input id="formato-manual-{{$contadorUrls}}"name="manuais[{{$contadorUrls}}][formato]" class="form-control mt-2" 
										type="text" placeholder="Formato/extensão do arquivo" value="{{$manual->formato}}"/>
									</label>
									<label for="tamanho-manual-{{$contadorUrls}}" class="form-group d-block"><span class="sr-only">Tamanho do arquivo</span>
									<input id="tamanho-manual-{{$contadorUrls}}" name="manuais[{{$contadorUrls}}][tamanho]" class="form-control mt-2" 
										type="text" placeholder="Tamanho do arquivo (em Megabytes)" value="{{$manual->tamanho}}"/>
									</label>
								</div>
							</div>
						</li>
						@php ($contadorUrls++)
						@endforeach
						@endif
					</ul>
				</div> 
			</div>
		</fieldset>

		<hr>

		<fieldset>
			<legend id="fotos-label-cab" class="obrigatorio mt-4 h3">
				Fotos do recurso
				<span class="sr-only">&nbsp;(Campo requerido)</span>
			</legend>
			<p>Carregue pelo menos uma foto sobre a tecnologia assistiva no formato png, jpg ou  jpeg</p>
			<div id="divFotos" class="form-group required row" role="group" aria-labelledby="fotos-label-cab">
				<div id="fotoDestaque" class="col-md-12">
					<label for="fotos" id="fotos-label" class="sr-only">
						Adicionar imagens do produto
						<span id="fotos-errors-messages"></span>
					</label>
					<input id="fotos" name="fotos[]" accept="image/*" type="file" data-browse-on-zone-click="true"  
							multiple data-show-upload="false" data-show-caption="true" 
							data-msg-placeholder="Faça o upload de ao menos uma foto do recurso" 
							data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
				</div>
				<div id="fotos-invalid-msg-placeholder"></div>
			</div>
		</fieldset>
		
		<hr>

		<div class="row py-4">
			<div class="col-3"	>
				<a id="btnRejeitar" href="{{url('/administrarRecursosTA')}}" class="btn btn-outline-danger p-4"><b>{{__('Cancelar')}}</b></a>
			</div>
			<div class="offset-7 col-2">
				<button id="btnEnviaForm" type="submit" class="btn btn-success p-4">
					<b>{{ __('PUBLICAR') }}</b>
					<span class="spinner-border d-none" role="status">
						<span class="sr-only">Publicando os dados do recurso...</span>
					</span>
				</button>
			</div>
		</div>
	</form>
</div>

<div class="modal alert alert-success hide fade in" data-keyboard="false" data-backdrop="static" id="modalRevisarRecurso">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h3 class="modal-title h4">Sucesso</h3>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
        <p class="server-response"></p>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <a class="btn btn-primary" href="{{url('/administrarRecursosTA')}}">Ok</a>
    </div>
</div>

@stop

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript">
	{{ $contadorArquivos = 0 }}

	$("#modalRevisarRecurso").modal("hide");
	function isUrlValid(url) {
		return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
	}

	var fotoDestaque = "";

	$("#fotos").fileinput({
		theme: "explorer-fa",
		language: "pt-BR",
		uploadAsync: true,
		previewFileType: "image",
		browseClass: "btn btn-success",
		browseIcon: "<i class='fa fa-file' aria-hidden='true'></i>",
		removeClass: "btn btn-danger",
		removeIcon: "<i class='fa fa-trash' aria-hidden='true'></i>",
		removeLabel: "Remover todas imagens",
		removeFromPreviewOnError: true,
		fileActionSettings: {
			showUpload: false,
			showZoom: true,
			showRemove: true,
			indicatorNew: '<i class="fa fa-exclamation-triangle text-warning"></i>'
		},
		overwriteInitial: false,
		previewZoomButtonIcons: {
    		prev: '<i class="fa fa-arrow-left"></i>',
   			next: '<i class="fa fa-arrow-right"></i>',
    		toggleheader: '<i class="fa fa-expand"></i>',
    		fullscreen: '<i class="fa fa-arrows-alt"></i>',
    		borderless: '<i class="fa fa-compress"></i>',
    		close: '<i class="fa fa-times"></i>'
		},
		previewZoomButtonClasses: {
			prev: 'btn btn-navigate',
    		next: 'btn btn-navigate',
    		toggleheader: 'btn btn-kv btn-default btn-outline-secondary',
    		fullscreen: 'btn btn-kv btn-default btn-outline-secondary',
    		borderless: 'btn btn-kv btn-default btn-outline-secondary',
    		close: 'btn btn-kv btn-default btn-outline-secondary'
		},
		previewThumbTags: {
			{!! "'{ID_FOTO_BANCO}' : '',
				   '{ID_FOTO_NOVA}' : '{ID_FOTO_NOVA}'
				 "  !!}
		},
		initialPreview: [@foreach($recursoTA->fotos as $foto)'<img src="{{url(Storage::url('public/'.$foto->caminho_arquivo))}}" class="file-preview-image kv-preview-data" alt="{{$foto->texto_alternativo}}">',@endforeach],
		initialPreviewConfig: [
		@foreach($recursoTA->fotos as $foto) 
			{!! '{ caption: "'.$foto->texto_alternativo.'",
				  size:"'.filesize(storage_path('app/public/'.$foto->caminho_arquivo)).'", 
				  url:"'.url('/removeFoto/'.$foto->id).'" }'
				  !!},
		 @endforeach			
		],
		initialPreviewThumbTags: [
		@foreach($recursoTA->fotos as $foto) 
			{!! "{ '{ID_FOTO_BANCO}': ".$foto->id.",
				   '{ID_FOTO_NOVA}' : '' ,
				   '{FOTO_DESTAQUE}' : '".($foto->destaque ? 'checked' : '')."'},"!!}
		 @endforeach			
		],
		initialPreviewShowDelete: true,
		uploadExtraData:{ _token: '{{ csrf_token()}}'},
		deleteExtraData: { _token: '{{ csrf_token()}}'},
		validateInitialCount: true,
		required: true,
		layoutTemplates: { 
				footer: '<div class="file-details-cell">' +
		                '<div class="explorer-caption" title="{caption}">{caption}'+            
		                '</div> ' + 
		                '<div class="clearfix pl-4">'+
		                    '<input class="form-check-input" type="radio" id="{ID_FOTO_BANCO}{ID_FOTO_NOVA}" name="fotoDestaque" value="{ID_FOTO_BANCO}{ID_FOTO_NOVA}" {FOTO_DESTAQUE}><label for="{ID_FOTO_BANCO}{ID_FOTO_NOVA}">Destaque</label>'+
		                    '<input name="textosAlternativos[{ID_FOTO_BANCO}{ID_FOTO_NOVA}][textoAlternativo]" type="text" class="form-control" placeholder="Texto alternativo" value="{caption}">'+        
		                '</div>'+
		                '{size}{progress}' +
		                '</div>' +
		                '<div class="file-actions-cell">{indicator} {actions}</div>',
				}

	});

	//Indexa os radiobuttons e campos de texto alternativo para evitar possíveis bugs ao utilizar dados da foto para isso
	$('#fotos').on('fileloaded', function(event, file, previewId, fileId, index, reader) {
		$('div[id="'+previewId+'"').children().each(function () {
    		$(this).html(function (i, html) {
        		return $(this).html().replace(/{ID_FOTO_NOVA}/g, 'nova-'+fileId);
    		});
		});
	});

	$("#fotos").on("filepredelete", function(jqXHR) {
        var abort = true;
        if (confirm("Tem certeza que deseja excluir a imagem?")) {
            abort = false;
        }
        return abort; // you can also send any data/object that you can receive on `filecustomerror` event
    }); 

	$(document).ready(function() {

		var contadorUrls = {{$contadorUrls}};

   		var form = $('#revisaoRecursoTA');

        form.submit(function(e) {
            var formData = new FormData(form[0]);

            e.preventDefault();
            //tinyMCE.triggerSave()
            $('#' + 'descricao').html( tinymce.get('descricao').getContent() );
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false, 
                data: formData,
                beforeSend: function(xhr)
                {
                    xhr.setRequestHeader('X-CSRFToken', '{{ csrf_token() }}');
                },
                success: function(respostaServidor)
                {
					$("#modalRevisarRecurso .server-response")
						.html("Recurso de Tecnologia Assistiva revisado e publicado com sucesso!");
					$("#modalRevisarRecurso").modal("show");
							
                },
				complete: function (xhr, status) 
				{
					$("#btnEnviaForm").children().first().removeClass("d-none");
					$("#btnEnviaForm").children().last().addClass("d-none");
					$("#btnEnviaForm").prop("disabled", false);
				},
				error: function(respostaServidor)
				{
					$('.invalid-feedback').remove();
					$('.sr-error-msg').remove();
					$("#alert-erros-formulario").addClass("d-none");
					
					var erros = JSON.parse(respostaServidor.responseText);
					if(erros){
						$.map(erros, function(val, key) {
							//testa se é um campo simples
							if(key.lastIndexOf(".")==-1){
								$('#'+key).after('<span class="invalid-feedback font-weight-bold d-block">'+val+'</span>');
								$('label[for="' + key + '"').append('<span class="sr-only sr-error-msg"> '+val+'</span>');
								$('#legend-label-'+key).html('<span class="sr-only sr-error-msg"> '+val+'</span>');
							}else{//se for um campo que pertence a um array
								//Se o feedaback de erro se referir a um campo de texto alternativo
								if(key.search("textoAlternativo")!=-1){
									$('[name^="textosAlternativos"][name$="[textoAlternativo]"]').each(function(i,elemento){ 
										if(!$(this).val()){
											$(this).after('<span class="invalid-feedback font-weight-bold d-block">'+val+'</span>')
										}
									});
								} else if (key.search("fotos.") != -1) {
									val.forEach(function (v) {
										$("#fotos-invalid-msg-placeholder").append('<span class="invalid-feedback font-weight-bold d-block">' + v + '</span>');
										$("#fotos-errors-messages").append('<span class="sr-error-msg">' + v + '</span>');
									});

								} else {
									var nomeArray = key.split('.');
									$('[name^="'+nomeArray[0]+'"][name$="['+nomeArray[1]+']['+nomeArray[2]+']"]')
										.after('<span class="invalid-feedback font-weight-bold d-block">'+val+'</span>')
										.after('<span class="sr-error-msg sr-only">'+val+'</span>');
										
								}
							}
						});
						$('html,body').animate({
							scrollTop: $('#alert-erros-formulario').offset().top
						},{
							duration:'slow', 
							complete: function () {
								$('#alert-erros-formulario').focus();
							}
						});

						$("#alert-erros-formulario").removeClass("d-none");
					}
					
				}
            });

			$("#btnEnviaForm").children().first().addClass("d-none");
			$("#btnEnviaForm").children().last().removeClass("d-none");
			$("#btnEnviaForm").prop("disabled", true);
        });

        // Preenche os campos de cada foto já cadastrada com as informações do banco
		@foreach($recursoTA->fotos as $foto)
		$('input[name*="{!!$foto->texto_alternativo!!}"]').val({!!'"'.$foto->texto_alternativo.'"'!!});
		@if($foto->destaque)
		$('input[value*="{!!$foto->texto_alternativo!!}"]').prop('checked', true);
		@endif
		@endforeach

		$('input[name="tags"]').amsifySuggestags({
			showAllSuggestions: true,
			selectOnHover: true,
			keepLastOnHoverTag: false,
			printValues: false,
			suggestions: @json($tagsDoSistema),
			defaultTagClass: 'tagChip',
			noSuggestionMsg: 'Tag não encontrada, tecle enter para criar uma nova',
		});
		$('input[class="amsify-suggestags-input"]')
			.attr("placeholder","Digite a tag")
			.attr("aria-labelledby", "tags-label");
		
		tinymce.init({
			selector:'textarea.descricao',
			language: 'pt_BR',  
			max_width: 400,
			height: 400,
			plugins: 'preview link lists',
			toolbar: 'preview | styleselect | fontsizeselect forecolor | bold italic underline | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | link ',
			default_link_target: '_blank',
			setup: function (editor) {
				editor.on('change', function () {
					tinymce.triggerSave();
				});		
			}
		});

		/**Mostra o input licença quando o for produto comercial**/
		$('input[type=radio][name=produtoComercial]').change(function () {
			if($(this).val() === 'true') {
				$('#divLicenca').removeClass('d-none');
			}
			else {
				$('#divLicenca').addClass('d-none');
			}
		});

		/**
		* Trecho relativo aos campos de vídeos
		*/
		var btnAdicionarVideo = $('#btnAdicionarVideo');
		var inputUrlVideo = $('#urlVideo');
		/**Adiciona a url do input video para a lista de urls**/
		btnAdicionarVideo.click(function(){

			inputUrlVideo.removeClass('is-invalid');
			inputUrlVideo.closest('div').find('span').remove();
			$('label[for="urlVideo"] .sr-error-msg').remove();

			if(inputUrlVideo.val().length!='0'){
				if(isUrlValid(inputUrlVideo.val())){
                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if ($('#videos').find('#avisoListaVazia-videos').length) {
					$('#videos').find('#avisoListaVazia-videos').remove();
				}

                $("#videos").append(
					'<li class="list-group-item">'+
					'<div class="card">'+
					'<div class="card-body">'+
					'<a href="'+inputUrlVideo.val()+'" class="col-md-10">'+
					'<span class="sr-only">Endereço do vídeo: </span>'+inputUrlVideo.val()+'</a>'+
					'<button type="button" aria-label="Remover vídeo" class="btn-remover-video btn btn-danger">' +
					'<i class="fa fa-trash" aria-hidden="true"></i>'+ 
					'</button>'+
					'<input name="videos['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+inputUrlVideo.val()+'"/>'+
					'</div>'+
					'</div>'+
					'</li>');
				contadorUrls++;

				$("#status-adicao-links").html("Link para o vídeo foi adicionado");
            }else{
            	inputUrlVideo.addClass("is-invalid");
				inputUrlVideo.closest('div').append('<span class="invalid-feedback">'+
													'<strong>Informe uma URL válida</strong>'+
													'</span>');
				inputUrlVideo.focus();
				$('label[for="urlVideo"] .sr-error-msg').remove();
				$('label[for="urlVideo"]').append('<span class="sr-error-msg">'+
												  '<strong>Informe uma URL válida</strong>'+
												  '</span>');
            }
        }else{
        	inputUrlVideo.addClass("is-invalid");
			inputUrlVideo.closest('div').append('<span class="invalid-feedback">'+
				'<strong>Informe uma URL antes de associar um vídeo ao recurso </strong>'+
				'</span>');
			inputUrlVideo.focus();
			$('label[for="urlVideo"] .sr-error-msg').remove();
			$('label[for="urlVideo"]').append('<span class="sr-error-msg sr-only">'+
				'<strong>Informe uma URL antes de associar um vídeo ao recurso </strong>'+
				'</span>');
        }
    });

		/**Remove a url do video ao clicar na lixeira**/
		$('#divVideos').on('click', '.btn-remover-video', function (evento) {
			evento.preventDefault();
			$(this).closest('li').remove();

			if ($('#videos li').length === 0) {
				$("#videos").append(
					'<li id="avisoListaVazia-videos" class="list-group-item">Não serão adicionados vídeos</li>');
			}
		});

		/**
		* Trecho referente ao campo arquivos
		*/
		var btnAdicionarArquivo = $('#btnAdicionarArquivo');
		var inputUrlArquivo = $('#urlArquivo'); 
		/**Adiciona a url do input arquivo para a lista de urls**/
		btnAdicionarArquivo.click(function(){

			inputUrlArquivo.removeClass('is-invalid');
			inputUrlArquivo.closest('div').find('span').remove();
			$('label[for="urlArquivo"] .sr-error-msg').remove();

			if(inputUrlArquivo.val().length!='0'){ 
				if(isUrlValid(inputUrlArquivo.val())){
                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if($('#arquivos').find('#avisoListaVazia-arquivos').length) {
				$('#arquivos').find('#avisoListaVazia-arquivos').remove();
			}  

			$("#arquivos").append(
				'<li class="list-group-item">'+
				'<div class="card">'+
				'<div class="card-body">'+
				'<a class="col-md-10" href="'+inputUrlArquivo.val()+'" class="mx-4">'+
				'<span class="sr-only">Endereço do arquivo: </span>'+inputUrlArquivo.val()+'</a>'+
				'<button type="button" aria-label="Remover arquivo" class="btn-remover-arquivo btn btn-danger">' +
				'<i class="fa fa-trash" aria-hidden="true"></i>'+ 
				'</button>'+
				'<input name="arquivos['+contadorUrls+'][url]" class="form-control mt-2" type="hidden" value="'+inputUrlArquivo.val()+'"/>'+
				'<label for="nome-arquivo-'+contadorUrls+'" class="form-group d-block"><span class="sr-only">Nome do arquivo</span>'+
				'<input id="nome-arquivo-'+contadorUrls+'" name="arquivos['+contadorUrls+'][nome]" class="form-control mt-2" type="text" placeholder="Nome do arquivo"/>'+
				'</label>'+
				'<label for="formato-arquivo-'+contadorUrls+'" class="form-group d-block"><span class="sr-only">Formato do arquivo</span>'+
				'<input id="formato-arquivo-'+contadorUrls+'"name="arquivos['+contadorUrls+'][formato]" class="form-control mt-2" type="text" placeholder="Formato/extensão do arquivo"/>'+
				'</label>'+
				'<label for="tamanho-arquivo-'+contadorUrls+'" class="form-group d-block"><span class="sr-only">Tamanho do arquivo</span>'+
				'<input id="tamanho-arquivo-'+contadorUrls+'" name="arquivos['+contadorUrls+'][tamanho]" class="form-control mt-2" type="text" placeholder="Tamanho do arquivo (em Megabytes)"/>'+    
				'</label>'+
				'</div>'+
				'</div>'+
				'</li>');
			
			$("#status-adicao-links").html("Link para o arquivo foi adicionado");
			$("#nome-arquivo-"+ contadorUrls).focus();
			contadorUrls++;
            }else{
            	inputUrlArquivo.addClass("is-invalid");
				inputUrlArquivo.closest('div').append('<span class="invalid-feedback">'+
					'<strong>Informe uma URL válida</strong>'+
					'</span>');
				inputUrlArquivo.focus();
				$('label[for="urlArquivo"] .sr-error-msg').remove();
				$('label[for="urlArquivo"]').append('<span class="sr-error-msg sr-only">'+
					'<strong>Informe uma URL válida</strong>'+
					'</span>');
            }
        }else{
        	inputUrlArquivo.addClass("is-invalid");
			inputUrlArquivo.closest('div').append('<span class="invalid-feedback">'+
				'<strong>Informe uma URL antes de associar um arquivo ao recurso </strong>'+
				'</span>');
			inputUrlArquivo.focus();
			$('label[for="urlArquivo"] .sr-error-msg').remove();
			$('label[for="urlArquivo"]').append('<span class="sr-error-msg sr-only">'+
				'<strong>Informe uma URL antes de associar um arquivo ao recurso </strong>'+
				'</span>');
			}
    });

		/**Remove da lista a url do arquivo ao clicar na lixeira**/
		$('#divArquivos').on('click', '.btn-remover-arquivo', function (evento) {

			evento.preventDefault();
			$(this).closest('li').remove();

			if ($('#arquivos li').length === 0) {
				$("#arquivos").append(
				'<li id="avisoListaVazia-arquivos" class="list-group-item">Não serão adicionados arquivos </li>');
			}
		});
		/**
		* Trecho referente aos campos dos manuais
		*/
		var btnAdicionarManual = $('#btnAdicionarManual');
		var inputUrlManual = $('#urlManual'); 
		/**Adiciona a url do input manual para a lista de urls**/
		btnAdicionarManual.click(function(){

			inputUrlManual.removeClass('is-invalid');
			inputUrlManual.closest('div').find('span').remove();
			$('label[for="urlManual"] .sr-error-msg').remove();

			if(inputUrlManual.val().length!='0'){
				if(isUrlValid(inputUrlManual.val())){

                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if($('#manuais').find('#avisoListaVazia-manuais').length) {
					$('#manuais').find('#avisoListaVazia-manuais').remove();
				}

                $("#manuais").append(
					'<li class="list-group-item">'+
					'<div class="card">'+
					'<div class="card-body">'+
					'<a class="col-md-10" href="'+inputUrlManual.val()+'" class="mx-4">'+
					'<span class="sr-only">Endereço do manual: </span>'+inputUrlManual.val()+'</a>'+
					'<button type="button" aria-label="Remover manual" class="btn-remover-manual btn btn-danger">' +
					'<i class="fa fa-trash" aria-hidden="true"></i>'+ 
					'</button>'+
					'<input name="manuais['+contadorUrls+'][url]" class="form-control mt-2" type="hidden" value="'+inputUrlManual.val()+'"/>'+
					'<label for="nome-manual-'+contadorUrls+'" class="form-group d-block"><span class="sr-only">Nome do manual</span>'+
					'<input id="nome-manual-'+contadorUrls+'" name="manuais['+contadorUrls+'][nome]" class="form-control mt-2" type="text" placeholder="Nome do manual"/>'+
					'</label>'+
					'<label for="formato-manual-'+contadorUrls+'" class="form-group d-block"><span class="sr-only">Formato do manual</span>'+
					'<input id="formato-manual-'+contadorUrls+'" name="manuais['+contadorUrls+'][formato]" class="form-control mt-2" type="text" placeholder="Formato/extensão do manual"/>'+
					'</label>'+
					'<label for="tamanho-manual-'+contadorUrls+'" class="form-group d-block"><span class="sr-only">Nome do manual</span>'+
					'<input id="tamanho-manual-'+contadorUrls+'" name="manuais['+contadorUrls+'][tamanho]" class="form-control mt-2" type="text" placeholder="Tamanho do manual (em Megabytes)"/>'+
					'</label>'+
					'</div>'+
					'</div>'+
					'</li>');

				$("#status-adicao-links").html("Link para o manual foi adicionado");
				$("#nome-manual-"+ contadorUrls).focus();
				contadorUrls++;
            }else{
            	inputUrlManual.addClass("is-invalid");
				inputUrlManual.closest('div').append('<span class="invalid-feedback">'+
					'<strong>Informe uma URL válida</strong>'+
					'</span>');
				inputUrlManual.focus();
				$('label[for="urlManual"] .sr-error-msg').remove();
				$('label[for="urlManual"]').append('<span class="sr-error-msg sr-only">'+
					'<strong>Informe uma URL válida</strong>'+
					'</span>');
            }

        }else{
        	inputUrlManual.addClass("is-invalid");
			inputUrlManual.closest('div').append('<span class="invalid-feedback">'+
				'<strong>Informe uma URL antes de associar um manual ao recurso</strong>'+
				'</span>');
			inputUrlManual.focus();
			$('label[for="urlManual"] .sr-error-msg').remove();
			$('label[for="urlManual"]').append('<span class="sr-error-msg sr-only">'+
				'<strong>Informe uma URL antes de associar um manual ao recurso</strong>'+
				'</span>');
        }
    });

		/**Remove da lista a url do manual ao clicar na lixeira**/
		$('#divManuais').on('click', '.btn-remover-manual', function (evento) {

			evento.preventDefault();
			$(this).closest('li').remove();

			if ($('#manuais li').length === 0) {
				$("#manuais").append(
					'<li id="avisoListaVazia-manuais" class="list-group-item">Não serão adicionados manuais </li>');
			}
		});

	} );
</script>
@stop
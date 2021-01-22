@extends('adminlte::page')

@section('title', 'Painel do Administrador - Revisar Publicação')

@section('content_header')
<h1 class="display-3">Adicionar Recurso de Tecnologia Assitiva</h1>
<p class="mt-3 ml-2"> Preencha o formulário e cadastre o recurso já com as tags e a publicação autorizadas.</p>
@stop

@section('content')
@php ($contadorUrls=0)
<div class="container">
	<form id="formCadastroRecursoTA" method="post" action="{{ route('insereRecursoTA') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group required row mt-3" role="group" aria-labelledby="titulo">
			<label for="titulo" class="col-12 col-form-label">{{ __('Título') }}</label>
			<div class="col-md-12">
				<input id="titulo" type="text" class="form-control" name="titulo" autofocus>
				<span class="invalid-feedback bold" role="alert" hidden></span>
			</div>
		</div>
		<hr>
		<div class="form-group required row" role="group" aria-labelledby="descricao">
			<label for="descricao" class="col-12 col-form-label">{{ __('Breve descrição') }}</label>
			<div class="col-12">
				<textarea class="form-control descricao" id="descricao" name="descricao">
				</textarea>
			</div>
		</div>
		<hr>
		<div class="form-group required row" role="group" aria-labelledby="siteFabricante">
			<label for="siteFabricante" class="col-12 col-form-label">{{ __('Site do fabricante') }}</label>
			<div class="col-12">
				<input id="siteFabricante" type="text" class="form-control" name="siteFabricante">
			</div>
		</div>
		<hr>
		<div class="form-group required row" role="group" aria-labelledby="informaSeProdutoComercial">
			<label id="informaSeProdutoComercial" class="col-4 col-form-label">É um produto comercial?</label> 
			<div id="produtoComercial" class="form-inline col-8">
				<div class="form-check-inline col-md-4 ">
					<input class="form-check-input" type="radio" id="comercial" name="produtoComercial" value="true">
					<label for="produtoComercial" class="form-check-label">{{ __('Sim') }}</label>
				</div>
				<div class="form-check-inline col-md-4 ">                            
					<input class="form-check-input" type="radio" id="naoComercial" name="produtoComercial" value="false" checked>
					<label for="produtoNaoComercial" class="form-check-label">{{ __('Não') }}</label>
				</div>
			</div>
		</div>
		<hr>
		<div id="divLicenca" class="form-group required row d-none" role="group" aria-labelledby="licenca">
			<label for="licenca" class="col-12 col-form-label">{{ __('Licença') }}</label>
			<div class="col-md-12">
				<input id="licenca" type="text" class="form-control" name="licenca">
			</div>
		</div>
		<hr>
		<div class="form-group required row" role="group" aria-labelledby="tags">
			<label for="tags" class="col-12 col-form-label">{{ __('Tags') }}</label>
			<div class="col-12">
				<input type="text" class="form-control" name="tags" id="tags"/>
			</div>
		</div>
		<hr>
		<div id="divManuais" class="form-group row" role="group" aria-labelledby="manuais associados">
			<label for="urlManual" class="col-12 col-form-label">{{ __('Manuais') }}</label>
			<div class="col-12 form-inline">
				<input id="urlManual" type="url"  class="w-75 form-control @error('manuais[]') is-invalid @enderror" name="manual" value="">
				<button id="btnAdicionarManual" type="button" class="w-25 btn btn-primary"><i class="fa fa-plus-square fa-1" aria-label="Adicionar"></i></button>
				@error('manuais[]')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="offset-md-1 col-md-10 mt-4">
				<label for="manuais">{{__('Manuais a serem cadastrados para este recurso:')}}</label>
				<ul id="manuais" class="list-group list-group-flush text-center">
					<li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais</li>
				</ul>
			</div> 
		</div>
		<hr>
		<div id="divArquivos" class="form-group row" role="group" aria-labelledby="arquivos associados">
			<label for="urlArquivo" class="col-12 col-form-label">{{ __('Arquivos') }}</label>
			<div class="col-12 form-inline">
				<input id="urlArquivo" type="url"  class="w-75 form-control @error('arquivos[]') is-invalid @enderror" name="arquivo" value="{{ old('arquivo') }}">
				<button id="btnAdicionarArquivo" type="button" class="w-25 btn btn-primary"><i class="fa fa-plus-square fa-1" aria-label="Adicionar"></i></button>
				@error('arquivos[]')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="offset-1 col-10 mt-4">
				<label for="arquivos">{{__('Arquivos a serem cadastrados para este recurso:')}}</label>
				<ul id="arquivos" class="list-group list-group-flush text-center">
					<li id="avisoListaVazia" class="list-group-item">Não serão adicionados arquivos</li>			
				</ul>                            
			</div>                                          
		</div>
		<hr>
		<div id="divVideos" class="form-group row" role="group" aria-labelledby="videos">
			<label for="urlVideo" class="col12 col-form-label">{{ __('Adicionar vídeo') }}</label>
			<div class="col-12 form-inline">
				<input id="urlVideo" type="url"  class="w-75 form-control @error('videos[]') is-invalid @enderror" name="video" value="{{ old('video') }}">
				<button id="btnAdicionarVideo" type="button" class="w-25 btn btn-primary"><i class="fa fa-plus-square fa-1" aria-label="Adicionar"></i></button>
				@error('videos[]')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="offset-md-1 col-md-10 mt-4">
				<label for="videos">{{__('Vídeos a serem cadastrados para este recurso:')}}</label>
				<ul id="videos" class="list-group list-group-flush text-center">
					<li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos</li>
				</ul>
			</div>                        
		</div>
		<hr>
		<div id="divFotos" class="form-group required row" role="group" aria-labelledby="fotos do recurso">
			<div id="fotoDestaque" class="col-12">
				<input id="fotos" name="fotos[]" accept="image/*" type="file" class="file" data-browse-on-zone-click="true"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Faça o upload de ao menos uma foto do recurso" data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
			</div>
		</div>
		<hr>
		<div class="row py-4">
			<div class="col-3"	>
				<a id="btnRejeitar" href="{{url('/administrarRecursosTA')}}" class="btn btn-danger"><b>Cancelar</b></a>
			</div>
			<div class="offset-7 col-2">
				<button id="btnEnviaForm" type="submit" class="btn btn-success">
					{{ __('Cadastrar') }}
				</button>
			</div>
		</div>
	</form>
</div>
<!-- The Modal -->
<div class="modal alert alert-success hide fade in" data-keyboard="false" data-backdrop="static" id="modalCadastroRealizado">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<!-- Modal Header -->
     		<div class="modal-header">
        		<h4 class="modal-title">Sucesso</h4>
    		</div>
    		<!-- Modal body -->
    		<div class="modal-body">
       			<p>O Recurso de Tecnologia Assistiva foi cadastrado com sucesso. Deseja adicionar outro recurso ou retornar à administração de recursos?</p>
    		</div>
   			<!-- Modal footer -->
    		<div class="modal-footer">
        		<a class="btn btn-primary" href="{{url('/administrarRecursosTA')}}">Ir para administração de recursos</a>
        		<a class="btn btn-primary" href="{{url('/adicionarRecursoTA')}}">Adicionar novo recurso</a>
    		</div>
		</div>
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
	var form = $('#formCadastroRecursoTA');

	function isUrlValid(url) {
		return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
	}
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
		removeLabel: "Limpar Novos Uploads",
		removeFromPreviewOnError: true,
		fileActionSettings: {
			showUpload: false,
			showZoom: false,
			indicatorNew: '<i class="fa fa-exclamation-triangle text-warning"></i>',
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
		uploadExtraData:{ _token: '{{ csrf_token()}}'},
		validateInitialCount: true,
		required: true,
		layoutTemplates: { 
				footer: '<div class="file-details-cell">' +
		                '<div class="explorer-caption" title="{caption}">{caption}'+            
		                '</div> ' + 
		                '<div class="clearfix pl-4">'+
		                    '<input class="form-check-input" type="radio" id="{ID_FOTO_NOVA}" name="fotoDestaque" value="{ID_FOTO_NOVA}" {FOTO_DESTAQUE}><label for="{ID_FOTO_NOVA}">Destaque</label>'+
		                    '<input name="textosAlternativos[{ID_FOTO_NOVA}][textoAlternativo]" type="text" class="form-control" placeholder="Texto alternativo" value="{caption}">'+        
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


	$(document).ready(function() {

		var contadorUrls = {{$contadorUrls}};

        $("#modalCadastroRealizado").modal("hide");

		form.submit(function(e) {
			var formData = new FormData(form[0]);

			e.preventDefault();
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
                        // open the other modal
                        $("#modalCadastroRealizado").modal("show");
                    },
                    error: function(respostaServidor)
                    {
                    	$('.invalid-feedback').remove();
                    	var erros = JSON.parse(respostaServidor.responseText);
                    	if(erros){
                    		$.map(erros, function(val, key) {
                            //testa se é um campo simples
                            if(key.lastIndexOf(".")==-1){
                            	$('#'+key).after('<span class="invalid-feedback font-weight-bold d-block" role="alert">'+val+'</span>');
                            }else{//se for um campo que pertence a um array
                                //Se o feedaback de erro se referir a um campo de texto alternativo
                                if(key.search("textoAlternativo")!=-1){
                                	$('[name^="textosAlternativos"][name$="[textoAlternativo]"]').each(function(i,elemento){ if(!$(this).val()){
                                		$(this).after('<span class="invalid-feedback font-weight-bold d-block" role="alert">'+val+'</span>')
                                	}
                                });
                                }else{
                                	var nomeArray = key.split('.');
                                	$('[name^="'+nomeArray[0]+'"][name$="['+nomeArray[1]+']['+nomeArray[2]+']"]').after('<span class="invalid-feedback font-weight-bold d-block" role="alert">'+val+'</span>');
                                }
                            }
                        });
                    		$('html,body').animate({scrollTop: $('.invalid-feedback').first().offset().top - 50},'slow');
                    	}
                    }
                });
		});

		$('input[name="tags"]').amsifySuggestags({
			showAllSuggestions: true,
			selectOnHover: true,
			keepLastOnHoverTag: false,
			printValues: false,
			suggestions: @json($tagsDoSistema),
			defaultTagClass: 'tagChip',
			noSuggestionMsg: 'Tag não encontrada, tecle enter para criar uma nova',
		});
		$('input[class="amsify-suggestags-input"]').attr("placeholder","Digite aqui");
		
		tinymce.init({
			selector:'textarea.descricao',
			language: 'pt_BR',  
			max_width: 400,
			height: 400,
			plugins: 'preview link',
			toolbar: 'preview wordcount link',
			default_link_target: '_blank',
			setup: function (editor) {
				editor.on('change', function () {
					tinymce.triggerSave();
				});		
			}
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

			if(inputUrlVideo.val().length!='0'){
				if(isUrlValid(inputUrlVideo.val())){
                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if ($('#videos').find('#avisoListaVazia').length) {
                	$('#videos').find('#avisoListaVazia').remove();
                }

                $("#videos").append(
                	'<li class="list-group-item">'+
                	'<div class="card">'+
                	'<div class="card-body">'+
                	'<h5 class="row">'+
                	'<a href="'+inputUrlVideo.val()+'" target="_blank" class="col-10">'+inputUrlVideo.val()+'</a>'+
                	'<i class="fa fa-trash col-2" aria-hidden="true"></i>'+
                	'<input name="videos['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+inputUrlVideo.val()+'"/>'+
                	'</h5>'+
                	'</div>'+
                	'</div>'+
                	'</li>');
                contadorUrls++;
            }else{
            	inputUrlVideo.addClass("is-invalid");
            	inputUrlVideo.closest('div').append(
            		'<span class="invalid-feedback" role="alert">'+
            		'<strong>Informe uma URL válida</strong>'+
            		'</span>');
            }
        }else{
        	inputUrlVideo.addClass("is-invalid");
        	inputUrlVideo.closest('div').append(
        		'<span class="invalid-feedback" role="alert">'+
        		'<strong>Informe uma URL antes de associar um vídeo ao recurso </strong>'+
        		'</span>');
        }
    });

		/**Remove a url do video ao clicar na lixeira**/
		$('#divVideos').on('click', '.fa-trash', function (evento) {

			evento.preventDefault();
			$(this).closest('li').remove();

			if ($('#videos li').length === 0) {
				$("#videos").append(
					'<li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos</li>');
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

			if(inputUrlArquivo.val().length!='0'){ 
				if(isUrlValid(inputUrlArquivo.val())){
                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if($('#arquivos').find('#avisoListaVazia').length) {
                	$('#arquivos').find('#avisoListaVazia').remove();
                }  

                $("#arquivos").append(
                	'<li class="list-group-item">'+
                	'<div class="card">'+
                	'<div class="card-body">'+
                	'<h5 class="row">'+
                	'<a class="col-10" href="'+inputUrlArquivo.val()+'" class="mx-4">'+inputUrlArquivo.val()+'</a>'+
                	'<i class="fa fa-trash col-2"></i></h5>'+
                	'</h5>'+
                	'<input name="arquivos['+contadorUrls+'][url]" class="form-control mt-2" type="hidden" value="'+inputUrlArquivo.val()+'"/>'+
                	'<input name="arquivos['+contadorUrls+'][nome]" class="form-control mt-2" type="text" placeholder="Nome do arquivo"/>'+
                	'<input name="arquivos['+contadorUrls+'][formato]" class="form-control mt-2" type="text" placeholder="Formato/extensão do arquivo"/>'+             
                	'<input name="arquivos['+contadorUrls+'][tamanho]" class="form-control mt-2" type="text" placeholder="Tamanho do arquivo (em Megabytes)"/>'+    
                	'</div>'+
                	'</div>'+
                	'</li>');
                contadorUrls++;
            }else{
            	inputUrlArquivo.addClass("is-invalid");
            	inputUrlArquivo.closest('div').append(
            		'<span class="invalid-feedback" role="alert">'+
            		'<strong>Informe uma URL válida</strong>'+
            		'</span>');
            }
        }else{
        	inputUrlArquivo.addClass("is-invalid");
        	inputUrlArquivo.closest('div').append(
        		'<span class="invalid-feedback" role="alert">'+
        		'<strong>Informe uma URL antes de associar um arquivo ao recurso </strong>'+
        		'</span>');
        }
    });

		/**Remove da lista a url do arquivo ao clicar na lixeira**/
		$('#divArquivos').on('click', '.fa-trash', function (evento) {

			evento.preventDefault();
			$(this).closest('li').remove();

			if ($('#arquivos li').length === 0) {
				$("#arquivos").append(
					'<li id="avisoListaVazia" class="list-group-item">Não serão adicionados arquivos </li>');
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

			if(inputUrlManual.val().length!='0'){
				if(isUrlValid(inputUrlManual.val())){

                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if($('#manuais').find('#avisoListaVazia').length) {
                	$('#manuais').find('#avisoListaVazia').remove();
                }

                $("#manuais").append(
                	'<li class="list-group-item">'+
                	'<div class="card">'+
                	'<div class="card-body">'+
                	'<h5 class="row">'+
                	'<a class="col-10" href="'+inputUrlManual.val()+'" class="mx-4">'+inputUrlManual.val()+'</a>'+
                	'<i class="fa fa-trash col-2"></i>'+
                	'</h5>'+
                	'<input name="manuais['+contadorUrls+'][url]" class="form-control mt-2" type="hidden" value="'+inputUrlManual.val()+'"/>'+
                	'<input name="manuais['+contadorUrls+'][nome]" class="form-control mt-2" type="text" placeholder="Nome do manual"/>'+
                	'<input name="manuais['+contadorUrls+'][formato]" class="form-control mt-2" type="text" placeholder="Formato/extensão do manual"/>'+
                	'<input name="manuais['+contadorUrls+'][tamanho]" class="form-control mt-2" type="text" placeholder="Tamanho do manual (em Megabytes)"/>'+
                	'</div>'+
                	'</div>'+
                	'</li>');
                contadorUrls++;
            }else{
            	inputUrlManual.addClass("is-invalid");
            	inputUrlManual.closest('div').append(
            		'<span class="invalid-feedback" role="alert">'+
            		'<strong>Informe uma URL válida</strong>'+
            		'</span>');
            }

        }else{
        	inputUrlManual.addClass("is-invalid");
        	inputUrlManual.closest('div').append(
        		'<span class="invalid-feedback" role="alert">'+
        		'<strong>Informe uma URL antes de associar um manual ao recurso</strong>'+
        		'</span>');
        }
    });

		/**Remove da lista a url do manual ao clicar na lixeira**/
		$('#divManuais').on('click', '.fa-trash', function (evento) {

			evento.preventDefault();
			$(this).closest('li').remove();

			if ($('#manuais li').length === 0) {
				$("#manuais").append(
					'<li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais </li>');
			}
		});

	} );
</script>
@stop
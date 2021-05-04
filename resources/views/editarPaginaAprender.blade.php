@extends('adminlte::page')

@section('title', 'Painel do Administrador - Editar Página "Aprender"')

@section('content_header')
<h1 class="display-3">Edição da Página <i>Aprender</i></h1>
<p class="mt-3 ml-2">Edite o conteúdo a ser exibido na página "Aprender"</p>
@endsection

@section('content')
<div class="container">
	<form id="editarPaginaAprender" method="post" action="{{ route('salvarEdicaoPaginaAprender') }}">
		@csrf
		<div class="form-group required row mt-3" role="group" aria-labelledby="titulo">
			<label for="titulo" class="col-12 col-form-label">{{ __('Título do Texto') }}</label>
			<div class="col-md-12">
				<input id="titulo" type="text" class="form-control" name="titulo" value="{!! html_entity_decode(stripslashes($conteudoPagina->titulo_texto), ENT_QUOTES, 'UTF-8')!!} 
" autofocus>
				<span class="invalid-feedback bold" role="alert" hidden></span>
			</div>
		</div>
		<hr>
		<div class="form-group required row" role="group" aria-labelledby="descricao">
			<label for="descricao" class="col-12 col-form-label">{{ __('Texto da Página') }}</label>
			<div class="col-12">
				<textarea class="form-control descricao" id="descricao" name="descricao">
					{!! html_entity_decode(stripslashes($conteudoPagina->texto), ENT_QUOTES, 'UTF-8')!!}
				</textarea>
			</div>
		</div>
		<hr>
		<div class="row py-4">
			<div class="col-3"	>
				<a id="btnVoltar" href="{{url('/painelAdministrador')}}" class="btn btn-danger"><b>{{ __('Voltar') }}</b></a>
			</div>
			<div class="offset-7 col-2">
				<button id="btnEnviaForm" type="submit" class="btn btn-success">
					{{ __('Publicar') }}
				</button>
			</div>
		</div>
	</form>
</div>
<!-- The Modal -->
<div class="modal alert alert-success hide fade in" data-keyboard="false" data-backdrop="static" id="modalPublicacaoRealizada">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<!-- Modal Header -->
     		<div class="modal-header">
        		<h4 class="modal-title">Sucesso</h4>
    		</div>
    		<!-- Modal body -->
    		<div class="modal-body">
       			<p>O conteúdo da página "Aprender" foi editado e publicado com sucesso!</p>
    		</div>
   			<!-- Modal footer -->
    		<div class="modal-footer">
        		<a class="btn btn-primary" href="{{url('/administrarRecursosTA')}}">Ir para administração de recursos</a>
    		</div>
		</div>
	</div>
</div>
@endsection

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {

		tinymce.init({
			selector:'textarea.descricao',
			language: 'pt_BR',  
			max_width: 400,
			height: 400,
			plugins: 'preview link lists',
			toolbar: 'undo redo | styleselect | forecolor | fontselect fontsizeselect bold italic | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link | preview',
			default_link_target: '_blank',
			setup: function (editor) {
				editor.on('change', function () {
					tinymce.triggerSave();
				});		
			}
		});

		var form = $('#editarPaginaAprender');

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
					$("#modalPublicacaoRealizada").modal("show");
                },
                error: function(respostaServidor)
                {
                    $('.invalid-feedback').remove();
                    var erros = JSON.parse(respostaServidor.responseText);
                    if(erros){
                    	$.map(erros, function(val, key) {
                            $('#'+key).after('<span class="invalid-feedback font-weight-bold d-block" role="alert">'+val+'</span>');
                        });
                    	$('html,body').animate({scrollTop: $('.invalid-feedback').first().offset().top - 50},'slow');
                    }
                }
            });
        });
	});
</script>
@endsection

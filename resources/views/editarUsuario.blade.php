@extends('adminlte::page')

@section('title', 'Painel do Administrador - Editar Usuário')

@section('content_header')
<h1 class="display-3">Editar Usuário</h1>
<p class="mt-3 ml-2"> Edite os dados dos usuários que administram o sistema</p>
@stop

@section('content')
<div class="container">
	<div id="alert-erros-formulario" tabindex="-1" class="alert alert-danger d-none">
		Por favor verifique o formulário novamente, alguns campos não foram preenchidos corretamente.
	</div>  
	<form id="formEdicaoUsuario" method="post" action="{{ route('atualizarUsuario', ['idUsuario' => $usuario->id ]) }}">
		{{ csrf_field() }}
		<div class="form-group row">
			<label for="name" class="col-md-4 col-form-label text-md-right">
				{{ __('Nome') }}
				<span class="sr-only error-msg"></span>
			</label>
			<div class="col-md-6">
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $usuario->name }}" autofocus>

				@error('name')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="email" class="col-md-4 col-form-label text-md-right">
				{{ __('Endereço de E-mail') }}
				<span class="sr-only error-msg"></span>
			</label>

			<div class="col-md-6">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $usuario->email }}">

				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
		</div>
		<div class="form-group row mb-0 mt-3">
			<div class="col-md-3 offset-md-9">
				<button type="submit" class="btn btn-primary">
					{{ __('Atualizar') }}
				</button>
			</div>
		</div>
	</form>
</div>

<div class="modal alert alert-success hide fade in" data-keyboard="false" data-backdrop="static" id="modalUsuarioAtualizado">
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
        <a class="btn btn-primary" href="{{route('administrarUsuarios')}}">Ok</a>
    </div>
</div>

@stop

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/personalizacoes-admin.css') }}" rel="stylesheet">
@stop

@section('js')

<script type="text/javascript">
	var form = $('#formEdicaoUsuario');
	form.submit(function(e) {
		var formData = new FormData(form[0]);

		e.preventDefault();
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false, 
			data: formData,
			beforeSend: function(xhr){
				xhr.setRequestHeader('X-CSRFToken', '{{ csrf_token() }}');
			},
			success: function(respostaServidor){
				$("#modalUsuarioAtualizado .server-response").html(respostaServidor);
				$("#modalUsuarioAtualizado").modal("show");
			},
			error: function(respostaServidor) {
				$(".invalid-feedback").remove();
				var errors = JSON.parse(respostaServidor.responseText);
				if (typeof(errors) === "string") {
					$("#modalUsuarioAtualizado .server-response").html(respostaServidor.responseJSON);
					$("#modalUsuarioAtualizado .modal-title").html("Aviso");
					$("#modalUsuarioAtualizado").modal("show");
				} else {
					$("#alert-erros-formulario").addClass("d-block").focus();
					$.each(errors, function (elmName, errorMsgs) {
						$("#" + elmName).parent().find(".error-msg").html(errorMsgs[0]);
						$("#" + elmName).parent().append('<span class="invalid-feedback d-block" role="alert">'
							+	'<strong class="error-msg">' + errorMsgs[0] + '</strong>'
							+ '</span>');
					});
				}
			}
		});
	});                    
</script>
@stop


@extends('adminlte::page')

@section('title', 'Painel do Administrador - Informações do Usuário')

@section('content_header')
<h1 class="display-3">Informações do Usuário</h1>
@stop

@section('content')
<div class="container">
	<div id="alert-erros-formulario" tabindex="-1" class="alert alert-danger d-none">
		Por favor verifique o formulário novamente, alguns campos não foram preenchidos corretamente.
	</div>  
	<form method="POST" id="formAtualizarUsuario" action="{{route('atualizarUsuario', $usuario->id)}}">
		@csrf
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="name">Nome:
				<span class="sr-only error-msg">
				</span>
			</label>
			<input type="text" class="form-control" name="name" id="name" value="{{__($usuario->name)}}">
			@error('name')
			<span class="invalid-feedback" role="alert">
				<strong class="error-msg">{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="email">E-mail:
				<span class="sr-only error-msg">
				</span>
			</label>
			<input type="text" class="form-control" name="email" id="email" value="{{__($usuario->email)}}">
			@error('email')
			<span class="invalid-feedback" role="alert">
				<strong class="error-msg">{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="password">Nova senha:
				<span class="sr-only error-msg">
				</span>
			</label>
			<input type="password" class="form-control" name="password" id="password">
				@error('password')
			<span class="invalid-feedback" role="alert">
				<strong class="error-msg">{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="password-confirm">Confirme a nova senha:</label>
			<input type="password" id="password-confirm" class="form-control" name="password_confirmation">
		</div>
		<div class="row justify-content-center">
			<div class="offset-1 col-2">
				<a href="{{url('/painelAdministrador')}}" class="btn btn-primary"><b>Cancelar</b></a>
			</div>
			<div class="offset-1 col-2">
				<button type="submit" class="btn btn-primary"><b>Salvar</b></button>
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
        <a class="btn btn-primary" href="{{url('/home')}}">Ok</a>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css"/>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#modalUsuarioAtualizado").modal("hide");
		var form = $("#formAtualizarUsuario");
		form.submit(function (ev) {
			var formData = new FormData(form[0]);
			ev.preventDefault();
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
						$("#alert-erros-formulario").addClass("d-block").focus();
						var errors = JSON.parse(respostaServidor.responseText);
						$.each(errors, function (elmName, errorMsgs) {
							$("#" + elmName).parent().find(".error-msg").html(errorMsgs[0]);
							$("#" + elmName).parent().append('<span class="invalid-feedback d-block" role="alert">'
								+	'<strong class="error-msg">' + errorMsgs[0] + '</strong>'
								+ '</span>');
						});
					}
			});
		});
	} );
</script>
@stop
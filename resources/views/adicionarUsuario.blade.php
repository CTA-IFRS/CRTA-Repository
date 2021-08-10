@extends('adminlte::page')

@section('title', 'Painel do Administrador - Adicionar Usuário')

@section('content_header')
<h1 class="display-3">Adicionar Usuário</h1>
<p class="mt-3 ml-2"> Cadastre novos usuários para que administrem o sistema</p>
@stop

@section('content')
<div class="container">
	<form id="formCadastroUsuario" method="post" action="{{ route('cadastrarUsuario') }}">
		{{ csrf_field() }}
		<div class="form-group row">
			<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
			<div class="col-md-6">
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>

				@error('name')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Endereço de E-mail') }}</label>

			<div class="col-md-6">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

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
				<p>Usuário cadastrado com sucesso. Deseja adicionar outro ou retornar à administração de usuários?</p>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<a class="btn btn-primary" href="{{url('/administrarUsuarios')}}">Ir para administração de usuários</a>
				<a class="btn btn-primary" href="{{url('/adicionarUsuarios')}}">Adicionar novo usuário</a>
			</div>
		</div>
	</div>
</div>
@stop

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/personalizacoes-admin.css') }}" rel="stylesheet">
@stop

@section('js')

<script type="text/javascript">	var form = $('#formCadastroUsuario');
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
                            }
                        });
                    		$('html,body').animate({scrollTop: $('.invalid-feedback').first().offset().top - 50},'slow');
                    	}
                    }
                });
	});
	$("#btnAutorizar").click(function(){
		if(confirm("Deseja confirmar o cadastro?")){
			return true;
		}	
		else{
			return false;
		}
	});

                    
</script>
@stop
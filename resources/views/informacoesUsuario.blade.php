@extends('adminlte::page')

@section('title', 'Painel do Administrador - Informações do Usuário')

@section('content_header')
<h1 class="display-3">Informações do Usuário</h1>
@stop

@section('content')
<div class="container">
	<form method="POST" action="{{route('atualizarUsuario', $usuario->id)}}">
		@csrf
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="exampleInputEmail1">Nome:</label>
			<input type="text" class="form-control" name="nomeUsuario" value="{{__($usuario->name)}}">
			@error('nomeTag')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="exampleInputEmail1">E-mail:</label>
			<input type="text" class="form-control" name="nomeUsuario" value="{{__($usuario->email)}}">
			@error('nomeTag')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="row justify-content-center">
			<div class="offset-1 col-2">
				<a href="{{url('/painelAdministrador')}}" class="btn btn-primary"><b>Cancelar</b></a>
			</div>
			<div class="offset-1 col-2">
				<button type="submit" class="btn btn-primary"><b>Salvar Edição</b></button>
			</div>					
		</div>
	</form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css"/>
@stop

@section('js')
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	} );
</script>
@stop
@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Tags')

@section('content_header')
<h1 class="display-3">Edição de Tag</h1>
@stop

@section('content')
<div class="container">
	<form method="POST" action="{{route("salvaEdicaoTag")}}">
		@csrf
		<input type="text" name="idTag" value="{{__($tag->id)}}" hidden/>
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="exampleInputEmail1">Nome da Tag</label>
			<input type="text" class="form-control" name="nomeTag" value="{{__($tag->nome)}}">
			@error('nomeTag')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group col-sm-6 col-12 mx-auto">
			<label for="exampleInputPassword1">Publicação Autorizada?</label>
			@if($tag->publicacao_autorizada==true)
			<td>
				<h4>
					<span class="badge badge-pill badge-success">Sim</span>
				</h4>
			</td>
			@else
			<td>
				<h4>
					<span class="badge badge-pill badge-danger">Não</span>
				</h4>
			</td>
			@endif
			<small id="ajudaPublicacaoAutorizada" class="form-text text-muted">*A publicação deve ser autorizada ou revogada na tela de Administração de Tags</small>
		</div>
		<div class="row justify-content-center">
			<div class="offset-1 col-2">
				<a href="{{url('/administrarTags')}}" class="btn btn-primary"><b>Cancelar</b></a>
			</div>
			<div class="offset-1 col-2">
				<button type="submit" class="btn btn-primary"><b>Salvar</b></button>
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
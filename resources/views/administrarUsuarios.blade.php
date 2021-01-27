@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Recursos TA')

@section('content_header')
<div class="row">
	<h1 class="display-3 col-md-10">Administrar Usuários</h1>
	<a href="{{url('/adicionarUsuario')}}" class="btn btn-primary col-md-2"><b>Adicionar Usuário</b></a>
</div>
@stop

@section('content')
<div class="container">
	<table id="tabelaUsuarios" class="table table-striped table-bordered dt-responsive w-100">
		<thead>
			<tr>
				<th>Ações</th>
				<th>Nome</th>
				<th>E-mail</th>				
				<th>Cadastrado em</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@isset($usuarios)
			@if(count($usuarios)>0)
			@foreach($usuarios as $usuario)
			<tr>
				<td></td>
				<td>{{$usuario->name}}</td>
				<td>{{$usuario->email}}</td>
				<td>{{$usuario->created_at->translatedFormat('d M Y')}}</td>
				<td>
					<table class="table">
						<tr>
							<td>
								<a id="btnEditar" href="{{url('/editarUsuario/'.__($usuario->id))}}" class="btn btn-primary"><b>Editar</b></a>
							</td>
							<td>
								<a id="btnExcluir" href="{{url('/excluirUsuario/'.__($usuario->id))}}" class="btn btn-danger"><b>Excluir</b></a>
							</td>
							<td>
								<a id="btnResetarSenha" href="#" class="btn btn-warning"><b>Enviar e-mail de recuperação de senha</b></a>
							</td>
						</tr>							
					</table>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<p class="text-danger"> Não há  outros usuários cadastrados na base de dados do RETACE</p>
			</tr>
			@endif
			@else
			<tr>
				<p class="text-danger"> Não há outros usuários cadastrados na base de dados do RETACE</p>
			</tr>			
			@endisset
		</tbody>
	</table>
</div>
@if(!empty($sucessoExclusao))
  <div class="alert alert-success"> {{ $sucessoExclusao }}</div>
@endif
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
		$("#btnOmitir").click(function(){
		if(confirm("Deseja ocultar o recurso? Ele permanecerá no banco de dados, mas não será visível aos usuários do RETACE")){
			return true;
		}	
		else{
			return false;
		}
	});
		$("#btnExcluir").click(function(){
		if(confirm("Deseja excluir o recurso? Essa ação é irreversível")){
			return true;
		}	
		else{
			return false;
		}
	});
		var table = $('#tabelaUsuarios').DataTable( {
			responsive: {
				details: {
					type: 'column'
				}
			},
			columnDefs: [
			{
				className: 'dtr-control',
				orderable: false,
				targets:   0
			} ],
			order: [ 1, 'des' ]	
		} );
	} );
</script>
@stop
@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Recursos TA')

@section('content_header')
<div class="row">
	<h1 class="display-3 col-md-10">Administrar Usuários</h1>
	<a href="{{route('adicionarUsuario')}}" class="btn btn-primary col-md-2"><b>Adicionar Usuário</b></a>
</div>
@stop

@section('content')
<div class="container">
	@if (session('info'))
		<div class="alert alert-success"> {{ session('info') }}</div>
	@elseif (session('warn'))
		<div class="alert alert-warning"> {{ session('warn') }}</div>
	@endif
	<table id="tabelaUsuarios" class="table table-striped table-bordered dt-responsive w-100">
		<thead>
			<tr>
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
				<td>{{$usuario->name}}</td>
				<td>{{$usuario->email}}</td>
				<td>{{$usuario->created_at->translatedFormat('d M Y')}}</td>
				<td>
					@if ($usuario->id != $usuarioAtualId)
						
					<a href="{{ route('editarUsuario', $usuario->id) }}" class="btnEditar btn btn-primary m-2"><b>Editar</b></a>
						<!-- <a href="{{url('/editarUsuario/'.__($usuario->id))}}" class="btnEditar btn btn-primary m-2"><b>Editar</b></a> -->
						<form class="formExcluirUsuario d-inline" method="post" action="{{route('excluirUsuario')}}">
							{{ csrf_field() }}
							<input name="idUsuario" type="hidden" value="{{$usuario->id}}">
							<button type="submit" class="btnExcluir btn btn-danger"><b>Excluir</b></button>
						</form>
						<a href="{{route('recuperarSenha', $usuario->id)}}" class="btnResetarSenha btn btn-warning m-2">
							<b>Enviar e-mail de recuperação de senha</b>
						</a>
						
					@else
						<a href="{{route('informacoesUsuario')}}" class="btnEditar btn btn-primary m-2"><b>Editar</b></a>
						<a href="{{route('informacoesUsuario')}}" class="btn btn-warning"><b>Alterar a senha</b></a>
					@endif
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
<!-- The Modal -->
<div class="modal alert hide fade in" data-keyboard="false" data-backdrop="static" id="modalSucessoExclusao">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Exclusão de usuário</h4>
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
	</div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css"/>
<link href="{{ asset('css/personalizacoes-admin.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var form = $('.formExcluirUsuario');
		form.submit(function(e) {
			var formData = new FormData(this);

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
					$("#modalSucessoExclusao .server-response").html(respostaServidor);
					$("#modalSucessoExclusao").modal("show");
				},
				error: function(respostaServidor)
				{
					$("#modalSucessoExclusao .server-response").html(respostaServidor.responseJSON);
					$("#modalSucessoExclusao").modal("show");
				}
			});
		});
		$(".btnResetarSenha").click(function(){
			return confirm("Deseja redefinir a senha do usuário?");
			
		});

		$(".btnExcluir").click(function(){
			return confirm("Deseja excluir o usuário? Essa ação é irreversível");
		});
		
		var table = $('#tabelaUsuarios').DataTable( {
			language: {
				url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
			},
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
			order: [ 1, 'asc' ]	
		} );
	} );
</script>
@stop


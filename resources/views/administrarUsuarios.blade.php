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
								<a id="btnEditar" type="button" href="{{url('/editarUsuario/'.__($usuario->id))}}" class="btn btn-primary"><b>Editar</b></a>
							</td>
							<td>
								<form id="formExcluirUsuario" method="post" action={{route('excluirUsuario')}}>
									{{ csrf_field() }}
									<input id="idUsuario" name="idUsuario" type="hidden" value="{{$usuario->id}}">
									<button id="btnExcluir" type="submit" class="btn btn-danger"><b>Excluir</b></button>
								</form>
							</td>
							<td>
								<a id="btnResetarSenha" type="button" href="{{url('/recuperarSenha/'.__($usuario->id))}}" class="btn btn-warning"><b>Enviar e-mail de recuperação de senha</b></a>
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
<!-- The Modal -->
<div class="modal alert hide fade in" data-keyboard="false" data-backdrop="static" id="modalSucessoExclusao">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Exclusão bem sucedida</h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<p>Usuário excluído com sucesso!</p>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<a class="btn btn-primary" href="{{url('/administrarUsuarios')}}">Ok</a>
			</div>
		</div>
	</div>
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
		var formExcluirUsuario = $('#formExcluirUsuario');
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
                        $("#modalSucessoExclusao").modal("show");
                    },
                    error: function(respostaServidor)
                    {
                    	alert("Erro ao excluir usuário");
                    }
                });
		});
		$("#btnResetarSenha").click(function(){
			if(confirm("Deseja redefinir a senha do usuário?")){
				return true;
			}	
			else{
				return false;
			}
		});

		$("#btnExcluir").click(function(){
			if(confirm("Deseja excluir o usuário? Essa ação é irreversível")){
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
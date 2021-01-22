@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Recursos TA')

@section('content_header')
<div class="row">
	<h1 class="display-3 col-md-10">Administrar Recursos de Tecnologia Assistiva</h1>
	<a href="{{url('/adicionarRecursoTA')}}" class="btn btn-primary col-md-2"><b>Adicionar Recurso</b></a>
</div>
@stop

@section('content')
<div class="container">
	<table id="tabelaRecursosTA" class="table table-striped table-bordered dt-responsive w-100">
		<thead>
			<tr>
				<th>Ações</th>
				<th>Título</th>
				<th>Cadastrado em</th>
				<th>Autorizado?</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@isset($recursosTA)
			@if(count($recursosTA)>0)
			@foreach($recursosTA as $recursoTA)
			<tr>
				<td></td>
				<td>{{__($recursoTA->titulo)}}</td>
				<td>{{__($recursoTA->created_at->translatedFormat('d M Y'))}}</td>
				<td class="text-center">
					<table class="table">
						<tr>
							@if($recursoTA->publicacao_autorizada==true)
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
						</tr>							
					</table>			
				</td>
				<td>
					<table class="table">
						<tr>
							<td>
								<a id="btnAutorizar" href="{{url('/revisarRecursoTA/'.__($recursoTA->id))}}" class="btn btn-warning"><b>Revisar</b></a>
							</td>
							<td class="text-center">
								<a id="btnOmitir" href="{{url('/omitirRecursoTA/'.__($recursoTA->id))}}" class="btn btn-warning"><b>Omitir</b></a>
							</td>
							<td>
								<a id="btnExcluir" href="{{url('/excluirRecursoTA/'.__($recursoTA->id))}}" class="btn btn-warning"><b>Excluir</b></a>
							</td>
						</tr>							
					</table>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<p class="text-danger"> Não há recursos cadastrados na base de dados do RETACE</p>
			</tr>
			@endif
			@else
			<tr>
				<p class="text-danger"> Não há recursos cadastrados na base de dados do RETACE</p>
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
		var table = $('#tabelaRecursosTA').DataTable( {
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
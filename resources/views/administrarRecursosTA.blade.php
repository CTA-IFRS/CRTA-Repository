@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Recursos TA')

@section('content_header')
<h1 class="display-3">Administrar Recursos de Tecnologia Assistiva</h1>
@stop

@section('content')
<div class="container">
	<table id="tabelaRecursosTA" class="table table-striped table-bordered dt-responsive w-100">
		<thead>
			<tr>
				<th>Expandir</th>
				<th>Título</th>
				<th>Descrição</th>
				<th>Cadastrado em</th>
				<th>Autorizado?</th>
				<th>Ações</th>
				<th>É produto comercial?</th>
				<th>Site do Fabricante</th>
				<th>Licença</th>
				<th>Número de Visualizações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($recursosTA as $recursoTA)
			<tr>
				<td></td>
				<td>{{__($recursoTA->titulo)}}</td>
				<td style="word-wrap: break-word;">{{ substr($recursoTA->descricao, 0, 150)." ..." }}</td>
				<td>{{__($recursoTA->created_at->translatedFormat('d M Y'))}}</td>
				<td class="text-center">
					@if($recursoTA->publicacao_autorizada==true)
					<h4>
						<span class="badge badge-pill badge-success">Sim</span>
					</h4>
					@else
					<h4>
						<span class="badge badge-pill badge-danger">Não</span>
					</h4>
					<button type="button" class="btn btn-warning mt-5"><b>Avaliar</b></button>
					@endif				
				</td>
				<td>
					<h4><button type="button" class="btn btn-primary"><b>Editar</b></button></h4>
					<button type="button" class="btn btn-primary mt-5"><b>Excluir</b></button>
				</td>
				<td>{{__($recursoTA->produto_comercial)}}</td>
				<td>{{__($recursoTA->site_fabricante)}}</td>
				<td>{{__($recursoTA->licenca)}}</td>
				<td>{{__($recursoTA->visualizacoes)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
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
		var table = $('#tabelaRecursosTA').DataTable( {
			responsive: {
				details: {
					type: 'column'
				}
			},
			columnDefs: [ 
			{ targets: [0, 1,2,3,4,5], visible: true},
			{ targets: '_all', visible: false },
			{
				className: 'dtr-control',
				orderable: false,
				targets:   0
			} ],
			order: [ 3, 'des' ]	
		} );
	} );
</script>
@stop
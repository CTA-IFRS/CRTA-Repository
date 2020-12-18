@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Recursos TA')

@section('content_header')
<h1 class="display-3">Administrar Recursos de Tecnologia Assistiva</h1>
@stop

@section('content')
<div>
	<table id="tabelaRecursosTA" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Título</th>
				<th>Descrição</th>
				<th>É produto comercial?</th>
				<th>Site do Fabricante</th>
				<th>Licença</th>
				<th>Publicação foi autorizada?</th>
				<th>Número de Visualizações</th>
			</tr>
		</thead>
		<tbody>
			@foreach($recursosTA as $recursoTA)
			<tr>
				<td>{{__($recursoTA->titulo)}}</td>
				<td style="word-wrap: break-word;">{{__($recursoTA->descricao)}}</td>
				<td>{{__($recursoTA->produto_comercial)}}</td>
				<td>{{__($recursoTA->site_fabricante)}}</td>
				<td>{{__($recursoTA->licenca)}}</td>
				<td>{{__($recursoTA->publicacao_autorizada)}}</td>
				<td>{{__($recursoTA->visualizacoes)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@stop

@section('css')
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#tabelaRecursosTA').DataTable( {
        responsive: true,
        paging: false
    } );
    new $.fn.dataTable.FixedHeader( table );
} );
</script>
@stop
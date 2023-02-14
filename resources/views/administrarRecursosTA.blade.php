@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Recursos TA')

@section('content_header')
<div class="row">
	<h1 class="display-3 col-md-10">Administrar Recursos de Tecnologia Assistiva</h1>
	<a href="{{route('adicionarRecursoTA')}}" class="btn btn-primary col-md-2"><b>Adicionar Recurso</b></a>
</div>
@stop

@section('content')
<div class="container">
	@if (session('sucessoExclusao'))
		<div class="alert alert-success"> {{ session('sucessoExclusao') }}</div>
	@endif
	<table id="tabelaRecursosTA" class="table table-striped table-bordered dt-responsive w-100">
		<thead>
			<tr>
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
				<td>{{__($recursoTA->titulo)}}</td>
				<td>
					<span class="d-none" aria-hidden="true">
						{{$recursoTA->created_at}}
					</span>
					{{__($recursoTA->created_at->translatedFormat('d M Y'))}}
				</td>
				<td class="align-middle text-center">
					@if($recursoTA->publicacao_autorizada==true)
						<span class="badge badge-pill badge-success">Sim</span>
					@else
						<span class="badge badge-pill badge-danger">Não</span>
					@endif								
				</td>
				<td class="align-middle text-center">
					
					<a href="{{route('revisarRecursoTA', $recursoTA->id)}}" class="btnAutorizar btn btn-warning m-2"><b>Revisar</b></a>
		
					<a  href="{{route('omitirRecursoTA', $recursoTA->id)}}" class="btnOmitir btn btn-warning"><b>Omitir</b></a>
		
					<a href="{{route('excluirRecursoTA', $recursoTA->id)}}" class="btnExcluir btn btn-warning m-2"><b>Excluir</b></a>
					
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
		$(".btnOmitir").click(function(){
		if(confirm("Deseja ocultar o recurso? Ele permanecerá no banco de dados, mas não será visível aos usuários do RETACE")){
			return true;
		}	
		else{
			return false;
		}
	});
		$(".btnExcluir").click(function(){
		if(confirm("Deseja excluir o recurso? Essa ação é irreversível")){
			return true;
		}	
		else{
			return false;
		}
	});
		var table = $('#tabelaRecursosTA').DataTable( {
			language: {
				url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
			},
			responsive: {
				details: {
					type: 'column'
				}
			},
			columnDefs: [
				// { className: 'dtr-control', orderable: false, targets:   0} 
				{ orderable: false, targets:   3} 
			],
			order: [[ 2, 'asc' ], [1, 'asc']]
		} );
	} );
</script>
@stop
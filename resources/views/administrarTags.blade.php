@extends('adminlte::page')

@section('title', 'Painel do Administrador - Administrar Tags')

@section('content_header')
<h1 class="display-3">Administrar Tags do Sistema</h1>
@stop

@section('content')
<div class="container">
	<table id="tabelaTags" class="table table-striped table-bordered dt-responsive w-100">
		<thead>
			<tr>
				<th>Ações</th>
				<th>Nome</th>
				<th>Cadastrada em</th>
				<th>Autorizada?</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@isset($tags)
			@if(count($tags)>0)
			@foreach($tags as $tag)
			<tr>
				<td></td>
				<td>{{__($tag->nome)}}</td>
				<td>{{__($tag->created_at->translatedFormat('d M Y'))}}</td>
				<td class="align-middle text-center">
					@if($tag->publicacao_autorizada)
						<span class="badge badge-pill badge-success">Sim</span>
					@else
						<span class="badge badge-pill badge-danger">Não</span>
					@endif								
				</td>
				<td class="align-middle text-center">
					@if($tag->publicacao_autorizada==false)
						<a href="{{url('/autorizaPublicacaoTag/'.__($tag->id))}}" type="button" class="btnAutorizar btn btn-warning m-2"><b>Aprovar</b></a>
					@else
						<a href="{{url('/omitirPublicacaoTag/'.__($tag->id))}}" type="button" class="btnOmitir btn btn-danger m-2"><b>Ocultar</b></a>
					@endif
						<a href="{{url('/editarTag/'.__($tag->id))}}" type="button" class="btnEditar btn btn-primary m-2"><b>Revisar</b></a>
						<a href="{{url('/removerTag/'.__($tag->id))}}" type="button" class="btnRemover btn btn-outline-danger m-2"><b>Remover</b></a>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<p class="text-danger">Não há tags cadastradas na base de dados do RETACE</p>
			</tr>
			@endif
			@else
			<tr>
				<p class="text-danger">Não há tags cadastradas na base de dados do RETACE</p>
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
		var table = $('#tabelaTags').DataTable( {
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
			order: [ 3, 'asc' ]	
		} );

		$(".btnAutorizar").click(function(){
			if(confirm("Deseja disponibilizar a tag para futuros cadastros de Recursos de TA no sistema?")){
				return true;
			}	
			else{
				return false;
			}
		});

		$(".btnOmitir").click(function(){
			if(confirm("Deseja indisponibilizar a tag para futuros cadastros no sistema? Recursos de TA que possuem a tag continuarão a tê-la, porém não será exibida")){
				return true;
			}	
			else{
				return false;
			}
		});

		$(".btnRemover").click(function(){
			if(confirm("Deseja remover a tag do sistema ? Recursos de TA que fiquem sem uma tag associada irão solicitar uma durante a revisão")){
				return true;
			}	
			else{
				return false;
			}
		});
	} );
</script>
@stop
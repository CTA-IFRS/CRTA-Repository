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
				<td class="text-center">
					<table class="table">
						<tr>
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
						</tr>							
					</table>			
				</td>
				<td>
					<table class="table">
						<tr>
							@if($tag->publicacao_autorizada==false)
							<td>
								<td>
									<a href="{{url('/autorizaPublicacaoTag/'.__($tag->id))}}" type="button" class="btnAutorizar btn btn-warning"><b>Aprovar</b></a>
								</td>
							</td>
							@else
							<td>
								<td>
									<a href="{{url('/omitirPublicacaoTag/'.__($tag->id))}}" type="button" class="btnOmitir btn btn-danger"><b>Ocultar</b></a>
								</td>
							</td>
							@endif
							<td>
								<a href="{{url('/editarTag/'.__($tag->id))}}"type="button" class="btnEditar btn btn-primary"><b>Revisar</b></a>
							</td>
						</tr>							
					</table>
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
			order: [ 1, 'des' ]	
		} );

		$(".btnAutorizar").click(function(){
			if(confirm("Deseja disponibilizar a tag para futuros cadastros de TAs no sistema?")){
				return true;
			}	
			else{
				return false;
			}
		});

		$(".btnOmitir").click(function(){
			if(confirm("Deseja indisponibilizar a tag para futuros cadastros no sistema? Tecnologias Assistivas que possuem a tag continuarão a tê-la, porém não será exibida")){
				return true;
			}	
			else{
				return false;
			}
		});
	} );
</script>
@stop
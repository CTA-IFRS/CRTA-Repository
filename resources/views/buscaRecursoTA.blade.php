@extends('layouts.siteLayout')

@section('titulo','RETACE Busca')

@section('conteudo')
<div class="container mt-5">
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<select class="selectpicker show-tick" data-width="auto" data-style="btn-primary" data-icon-base="fa">
					<option data-icon="fa-tag">TAG</option>
					<option data-icon="fa-font">Termo</option>
				</select>
			</div>
			<input type="text" class="form-control" placeholder="Busque recursos de tecnologia assistiva" aria-label="Campo de busca com seletor para optar entre buscar por TAGs ou termos">
			<div class="input-group-append">
				<button class="btn btn-primary" type="button">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>						
	</form>
	<div id="resultadoBusca" class="mt-3">
		@if($tag!=null)
			<h3> Resultado da busca pela tag <i>{{$tag}}</i> </h3>
		@endif 
		@include('layouts.listaCardsRecursos')
	</div>
</div>
@endsection


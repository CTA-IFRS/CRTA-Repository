@extends('layouts.siteLayout')
@section('titulo','RETACE Teste Cards TA')
@section('conteudo')
<div class="container mt-5">
	<h1 >Recursos Cadastrados</h1>

	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
		@foreach($recursosTA as $recursoTA)
		<div class="col mb-4">
			<div class="card"> <!--style="min-width: 18rem;"-->
				@foreach($recursoTA->fotos as $foto)
					@if($foto->destaque==true)
					<img class="card-img-top" src="{{Storage::url('public/'.$foto->caminho_arquivo)}}" alt="{{$foto->texto_alternativo}}">
					@endif
				@endforeach
				<div class="card-body">
					<h3 class="card-title"><a href="#" class="card-link">{{ $recursoTA->titulo }}</a></h3>
					<p class="card-text">{{ substr($recursoTA->descricao, 0, 200)." ..." }}</p>
				</div>
				<div class="card-footer">
					{{__("Avaliação pelos usuários")}}
				</div>
			</div>
		</div>
		@endforeach

		<div class="row mt-2">
			{{$recursosTA->links()}}
		</div>
	</div>
	@endsection

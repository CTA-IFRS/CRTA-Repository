@extends('layouts.siteLayout')
@section('titulo','RETACE Lista de Recursos de TA')
@section('conteudo')
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@foreach($recursosTA as $recursoTA)
			<div class="card">
				<div class="card-header">{{ $recursoTA->titulo }}</div>
				<div class="card-body">
					<div class="row">
						<label for="descricao" class="col-md-4 text-md-right">Título</label>
						<p id="descricao" class="col-md-8">{{ $recursoTA->descricao }}</p>
					</div>
					<div class="row">
						<label for="produtoComercial" class="col-md-4 text-md-right">Descrição</label>
						<p id="produtoComercial" class="col-md-8">{{ $recursoTA->produto_comercial }}</p>
					</div>
					<div class="row">
						<label for="site_fabricante	bricante" class="col-md-4 text-md-right">Site do fabricante</label>
						<p id="siteFrabricante" class="col-md-8">{{ $recursoTA->site_fabricante }}</p>
					</div>
					<div class="row">
						<label for="licenca" class="col-md-4 text-md-right">Licença</label>
						<p id="licenca" class="col-md-8">{{ $recursoTA->licenca }}</p>
					</div>
					<div class="row">
						<label for="tags" class="col-md-4 text-md-right">Tags</label>
						<ul id="tags" class="list-group text-center col-md-8">
							@foreach($recursoTA->tags as $tag)
								<li class="list-group-item ">{{ $tag->nome }}: {{$tag->descricao}}</li>
							@endforeach
						</ul>
					</div>
					<div class="row">
						<label for="videos" class="col-md-4 text-md-right">Vídeos</label>
						<ul id="videos" class="list-group text-center col-md-8">
							@foreach($recursoTA->videos as $video)
								<li class="list-group-item">{{ $video->url }}: {{$video->destaque}}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
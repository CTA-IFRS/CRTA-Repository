<!--layou para listagens de alguns recursos em que a paginação é desnecessária (ex: recursos relacionados, listagem na página inicial. Se for preciso paginação, utilizar o layout listaCardsRecursos. -->
<div id="listagemRecursos" class="container mt-5">
	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
		@foreach($recursosTA as $recursoTA)
		<div class="col mb-4" >
			<div class="card"> <!--style="min-width: 18rem;"-->
				@foreach($recursoTA->fotos as $foto)
				@if($foto->destaque==true)
				<img class="card-img-top" src="{{Storage::url('public/'.$foto->caminho_thumbnail)}}" alt="{{$foto->texto_alternativo}}">
				@endif
				@endforeach
				<div class="card-body">
					<h3 class="card-title"><a href="{{url('exibeRecursoTA/'.$recursoTA->id)}}" class="card-link">{{ $recursoTA->titulo }}</a></h3>
					<p class="card-text">{{ substr($recursoTA->descricao, 0, 200)." ..." }}</p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
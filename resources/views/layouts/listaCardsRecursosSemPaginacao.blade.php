<!--layou para listagens de alguns recursos em que a paginação é desnecessária (ex: recursos relacionados, listagem na página inicial. Se for preciso paginação, utilizar o layout listaCardsRecursos. -->
<div class="container mt-5">
	<div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
		@foreach($recursosTA as $recursoTA)
		<div class="col mb-4" >
			<div class="card card-recurso-ta pt-2 pl-4 pr-3 pb-2 d-flex flex-column h-100"> <!--style="min-width: 18rem;"-->
				<div class="row mt-auto mb-auto">
					<!--tirar depois--><img class="card-img-top col-5 m-auto" src="https://cta-api.ifrs.edu.br/repositorio/storage/thumbnails/1640888757_Foto DarkReader.jpg" alt="Foto DarkReader">
					@foreach($recursoTA->fotos as $foto)
					@if($foto->destaque==true)
					<img class="card-img-top col-5 m-auto" src="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" alt="{{$foto->texto_alternativo}}">
					@endif
					@endforeach
					<div class="card-body col-7 pl-2">
						<h3 class="card-title"><a href="{{route('exibeRecursoTASlug', $recursoTA->slug)}}" class="card-link">{{ $recursoTA->titulo }}</a></h3>
						<p class="card-text">{{ html_entity_decode(substr(strip_tags($recursoTA->descricao), 0, 200), ENT_QUOTES, 'UTF-8')." ..." }}</p>
					</div>
				</div>
				
			</div>
		</div>
		@endforeach
	</div>
</div>
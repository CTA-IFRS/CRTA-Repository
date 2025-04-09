<div id="listagemRecursos" class="mt-2">
	<h3>{{ count($recursosTA) }} resultados</h3>
	<div id="listagem_filtros" class="row">
		<div class="col-md-2_5 col-12 p-0">
		@include('layouts.filtragemBusca')
		</div>
		<div id="listagem_recursos_paginacao" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 col-md-7_5 col-12 p-0">
			@foreach($recursosTA as $recursoTA)
			<div class="col mb-4" >
				<div class="card card-recurso-ta d-flex flex-column h-100">
					<a href="{{route('exibeRecursoTASlug', $recursoTA->slug)}}" class="card-link">
						@foreach($recursoTA->fotos as $foto)
						@if($foto->destaque==true)
						<div class="hoverImageWrapper m-2">
							<img class="hoverImage card-img-top" src="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" alt="{{$foto->texto_alternativo}}">
						</div>
						@endif
						@endforeach
						<div class="card-body">
							<h3 class="card-title">{{ $recursoTA->titulo }}</h3>
							<p class="card-text">{{ html_entity_decode(substr(strip_tags($recursoTA->descricao), 0, 150), ENT_QUOTES, 'UTF-8')." ..." }}</p>
						</div>
					</a>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<div class="row mt-2 justify-content-center">
	@include('layouts.paginacao')
	</div>
</div>
<script>

	document.addEventListener('DOMContentLoaded', function () {
		function atualizaListagem(numeroPagina) {
			var local = window.location;
			$.ajax({
				url: local.origin + "/listar/cards-recursos" + "?page=" + numeroPagina,
				success: function(novaListagemRecursos) {
					//window.history.pushState(local.origin, "RETACE Início", "/?page=" + numeroPagina);
					$('#listagemRecursos').html(novaListagemRecursos);
				}
			});
		}
		$(document).on('click', '.pagination a', function(event) {
			event.preventDefault();
			var numeroPagina = $(this).attr('href').split('page=')[1];
			atualizaListagem(numeroPagina);
		});

	});

	document.addEventListener('DOMContentLoaded', function() {

		const links = document.querySelectorAll('.card-link');

		links.forEach(link => {
			const card = link.closest('.card-recurso-ta');
	
			link.addEventListener('focus', () => {
				card.classList.add('focused', 'hover');
			});
	
			link.addEventListener('blur', () => {
				card.classList.remove('focused', 'hover');
			});
		});
	});

</script>
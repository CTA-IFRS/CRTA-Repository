<div id="listagemRecursos" class="mt-2">
	<h3>{{ count($recursosTA) }} resultados</h3>
	<div id="listagem_filtros">
		<div>
		@include('layouts.filtragemBusca')
		</div>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
			@foreach($recursosTA as $recursoTA)
			<div class="col mb-4" >
				<div class="card card-recurso-ta">
					@foreach($recursoTA->fotos as $foto)
					@if($foto->destaque==true)
					<img class="card-img-top" src="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" alt="{{$foto->texto_alternativo}}">
					@endif
					@endforeach
					<div class="card-body">
						<h3 class="card-title"><a href="{{route('exibeRecursoTASlug', $recursoTA->slug)}}" class="card-link">{{ $recursoTA->titulo }}</a></h3>
						<p class="card-text">{{ html_entity_decode(substr(strip_tags($recursoTA->descricao), 0, 200), ENT_QUOTES, 'UTF-8')." ..." }}</p>
					</div>

				</div>
			</div>
			@endforeach
		</div>
	</div>
	<div class="row mt-2 justify-content-center">

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
</script>
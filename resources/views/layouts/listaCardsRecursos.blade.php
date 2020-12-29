<div id="listagemRecursos" class="container mt-5">
	<h3> Total: {{ count($recursosTA) }} </h3>
	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
		@foreach($recursosTA as $recursoTA)
		<div class="col mb-4" >
			<div class="card">
				@foreach($recursoTA->fotos as $foto)
				@if($foto->destaque==true)
				<img class="card-img-top" src="{{Storage::url('public/'.$foto->caminho_thumbnail)}}" alt="{{$foto->texto_alternativo}}">
				@endif
				@endforeach
				<div class="card-body">
					<h3 class="card-title"><a href="{{url('exibeRecursoTA/'.$recursoTA->id)}}" class="card-link">{{ $recursoTA->titulo }}</a></h3>
					<p class="card-text">{{ substr(strip_tags($recursoTA->descricao, 0, 200))." ..." }}</p>
				</div>

			</div>
		</div>
		@endforeach
	</div>
	<div class="row mt-2 justify-content-center">

	</div>
</div>
<script>

	document.addEventListener('DOMContentLoaded', function () {
		function atualizaListagem(numeroPagina) {
			var local = window.location;
			$.ajax({
				url: local.origin + "/listaCardsRecursos" + "?page=" + numeroPagina,
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

<form id="buscaRecursosTA" method="post" action="{{route('filtroPost')}}">
	{{ csrf_field() }}
	<div class="row col-sm-12 col-12 justify-content-center justify-content-sm-center no-gutters input-group mb-3" id="box-form">
		<div class="col-sm-12">
			<input type="text" name="texto" class="form-control" placeholder="Busque recursos de tecnologia assistiva" aria-label="Campo de busca com seletor para optar entre buscar por TAGs ou termos">
		</div>
		<div class="input-group-append">
			<button class="btn btn-primary" type="submit" id="btnSearch">
				<i class="fa fa-search" aria-hidden="true"></i>
				<span class="sr-only">Pesquisar</span>
			</button>
		</div>
	</div>		
</form>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		$('input[name="texto"]').autocomplete({
			source: {!! $tags ?? '{}' !!},
			messages: {
				noResults: 'Sem resultados',
				results: function(amount) {
					if (amount > 1) {
						return 'Foram encontrados ' + amount + ' resultados';
					} else {
						return 'Foi encontrado 1 resultado';
					}
				}
    		}
		});
	});
</script>



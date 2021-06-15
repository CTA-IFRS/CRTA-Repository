
<form id="buscaRecursosTA" method="get" action="/filtro">
	<div class="row col-sm-12 col-12 justify-content-center justify-content-sm-center no-gutters input-group mb-3">
		<div class="input-group-prepend">
			<input type="hidden" name="tipoBusca">
			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" 
					aria-haspopup="true" aria-expanded="false" aria-label="Termo - Pesquisar por termos">
					Termo
			</button>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="#" aria-label="TAG - Pesquisar por TAGs">TAG</a>
				<a class="dropdown-item" href="#" aria-label="Termo - Pesquisar por termos">Termo</a>
				<div role="separator" class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" aria-label="Ver Todos - Retornar todos os recursos registrados">Ver todos</a>
			</div>					
		</div>
		<div class="col-sm-9 col-7">
			<input type="text" name="termo" class="form-control" placeholder="Busque recursos de tecnologia assistiva" aria-label="Campo de busca com seletor para optar entre buscar por TAGs ou termos" required>
		</div>
		<div class="col-sm-1 col-1 input-group-append">
			<button class="btn btn-primary" type="submit" id="btnSearch">
				<i class="fa fa-search" aria-hidden="true"></i>
				<span class="sr-only">Pesquisar</span>
			</button>
		</div>
	</div>		
</form>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		$('input[name="tipoBusca"]').val('termo');
		$("#buscaRecursosTA").attr('action', "{{ route('filtro', ['tipoBusca' => $tipoBusca ?? '' ]) }}")	

		$('.dropdown-item').on('click',  function(){
			var seletorFiltro = $(this).parent().siblings('button');
			var opcaoEscolhida = $(this).text();

			$(seletorFiltro).text(opcaoEscolhida);
			$(seletorFiltro).val(opcaoEscolhida);
			$(seletorFiltro).attr('aria-label', $(this).attr('aria-label'));

			if(opcaoEscolhida==="TAG"){
				$('input[name="termo"]').removeAttr('disabled');
				$('input[name="tipoBusca"]').val('tags');
				$('input[name="termo"]').amsifySuggestags({
					showAllSuggestions: true,
					whiteList: true,
					selectOnHover: true,
					keepLastOnHoverTag: false,
					printValues: false,
					suggestions: {!!$tagsCadastradas ?? '{}' !!},
					defaultTagClass: 'tagChip',
					noSuggestionMsg: 'Categoria não encontrada'
				});
				$('input[class="amsify-suggestags-input"]')
					.attr("placeholder","Busque por TAGs")
					.focus();        	
				$("#buscaRecursosTA").attr('action', "{{ route('filtro', ['tipoBusca' => $tipoBusca ?? '', 'tags' => $termo ?? '']) }}");

			}else if(opcaoEscolhida==="Termo"){
				$('input[name="termo"]').amsifySuggestags({}, 'destroy');
				$('input[name="tipoBusca"]').val('termo');
				$('input[name="termo"]')
					.attr("placeholder","Digite e busque por palavras no titulo ou descrição da TA")
					.val("")
					.removeAttr('disabled')
					.focus();
				$("#buscaRecursosTA").attr('action', "{{ route('filtro', ['tipoBusca' => $tipoBusca ?? '', 'termo' => $termo ?? '']) }}");

			}else{
				$('input[name="termo"]').amsifySuggestags({}, 'destroy');
				$('input[name="tipoBusca"]').val('todos');
				$('input[name="termo"]').attr('disabled','disabled');
				$('input[name="termo"]').attr("placeholder","Busque por todas as tecnologias assistivas cadastradas");
				$("#buscaRecursosTA").attr('action', "{{ route('filtro', ['tipoBusca' => $tipoBusca ?? '' ]) }}");       
				$("#btnSearch").focus(); 		
			}

		});
	});	
</script>



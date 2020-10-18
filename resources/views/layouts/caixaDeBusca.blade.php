<form id="buscaRecursosTA" method="get">
	<div class="row">
		<div class="col-sm-12">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<select id="seletorBusca" class="selectpicker show-tick" data-width="auto" data-style="btn-primary" data-icon-base="fa">
						<option data-icon="fa-tag" value="tag">TAG</option>
						<option data-icon="fa-font" value="termo">Termo</option>
						<option data-icon="fa-th-list" value="todos" selected>Ver todos</option>
					</select>
				</div>
				<input type="text" name="parametros" class="form-control" placeholder="Busque recursos de tecnologia assistiva" aria-label="Campo de busca com seletor para optar entre buscar por TAGs ou termos">
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>						
</form>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {

		$("#seletorBusca").change(function() {
			var selected = $(this).children(":selected").val();
			switch (selected) {
				case "tag":
				$('input[name="parametros"]').amsifySuggestags({
					showAllSuggestions: true,
					whiteList: true,
					selectOnHover: true,
					keepLastOnHoverTag: false,
					printValues: false,
					suggestions: {!!$tagsCadastradas ?? '{}' !!},
					defaultTagClass: 'tagChip',
					noSuggestionMsg: 'Categoria não encontrada',
				});
				$('input[name="parametros"]').attr("placeholder","Escolha e realize a busca por TAGs");
				$('div[class="amsify-suggestags-area"]')[0].style.setProperty('width', '81%', 'important');
				$("#buscaRecursosTA").attr('action', '/buscaRecursoTAPorTag');
				alert("Form Action is Changed to /buscaRecursoTAPorTag");
				break;

				case "termo":
				$('input[name="parametros"]').amsifySuggestags({}, 'destroy');
				$("#buscaRecursosTA").attr('action', '/buscaRecursoTAPorTermo');
				alert("Form Action is Changed to /buscaRecursoTAPorTermo");
				break;

				case "todos":
				$('input[name="parametros"]').amsifySuggestags({}, 'destroy');
				$("#buscaRecursosTA").attr('action', '/buscaRecursoTAPorTag');
				alert("Form Action is Changed to todos");
				break;

				default:
				$("#buscaRecursosTA").attr('action', '/buscaRecursoTAPorTag');
			}
		});
	});	
</script>
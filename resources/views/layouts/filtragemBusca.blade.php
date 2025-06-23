<!-- Botão de Filtros visível apenas em telas pequenas -->
<button id="btn_filtros" class="btn btn-primary d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtroDiv" aria-expanded="false" aria-controls="filtroDiv">
  Exibir Filtros
  <i class="fa fa-filter" aria-hidden="true"></i>
</button>

<!-- Box de filtros com colapso em telas pequenas -->
<div class="collapse d-lg-block" id="filtroDiv">
  <form class="box-filtros bg-white rounded p-4" method="post" action="{{route('filtroPost')}}">
    {{ csrf_field() }}
    <input type="hidden" name="texto" value="{{$parametro}}" />
    <h4 class="d-none d-lg-block">Filtros</h4>
    <hr class="d-none d-lg-block">
    <details class="filter-category">
      <summary class="mb-2">Condição</summary>
      <div class="filter-options">
        <ul>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Baixa visão" class="custom-control-input" id="filter1">
              <label class="custom-control-label" for="filter1">Baixa visão</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Cegueira" class="custom-control-input" id="filter2">
              <label class="custom-control-label" for="filter2">Cegueira</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Deficiência auditiva" class="custom-control-input" id="filter3">
              <label class="custom-control-label" for="filter3">Deficiência auditiva</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Surdez" class="custom-control-input" id="filter4">
              <label class="custom-control-label" for="filter4">Surdez</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Surdocegueira" class="custom-control-input" id="filter5">
              <label class="custom-control-label" for="filter5">Surdocegueira</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Deficiência física" class="custom-control-input" id="filter6">
              <label class="custom-control-label" for="filter6">Deficiência física</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Deficiência intelectual" class="custom-control-input" id="filter7">
              <label class="custom-control-label" for="filter7">Deficiência intelectual</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Austismo" class="custom-control-input" id="filter8">
              <label class="custom-control-label" for="filter8">Austismo</label>
            </div>
          </li>
        </ul>
      </div>
    </details>
    <details class="filter-category">
      <summary class="mb-2">Necessidade</summary>
      <div class="filter-options">
        <ul>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Comunicação" class="custom-control-input" id="filter9">
              <label class="custom-control-label" for="filter9">Comunicação</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Mobilidade" class="custom-control-input" id="filter10">
              <label class="custom-control-label" for="filter10">Mobilidade</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Braille" class="custom-control-input" id="filter11">
              <label class="custom-control-label" for="filter11">Braille</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Libras" class="custom-control-input" id="filter12">
              <label class="custom-control-label" for="filter12">Libras</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Leitor de tela" class="custom-control-input" id="filter13">
              <label class="custom-control-label" for="filter13">Leitor de tela</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Mouse" class="custom-control-input" id="filter14">
              <label class="custom-control-label" for="filter14">Mouse</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Teclado" class="custom-control-input" id="filter15">
              <label class="custom-control-label" for="filter15">Teclado</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Material tátil" class="custom-control-input" id="filter16">
              <label class="custom-control-label" for="filter16">Material tátil</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Objeto de Aprendizagem" class="custom-control-input" id="filter17">
              <label class="custom-control-label" for="filter17">Objeto de Aprendizagem</label>
            </div>
          </li>
        </ul>
      </div>
    </details>
    <details class="filter-category">
      <summary class="mb-2">Outros</summary>
      <div class="filter-options">
        <ul>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Gratuito" class="custom-control-input" id="filter18">
              <label class="custom-control-label" for="filter18">Gratuito</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Baixo custo" class="custom-control-input" id="filter19">
              <label class="custom-control-label" for="filter19">Baixo custo</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="Comercial" class="custom-control-input" id="filter20">
              <label class="custom-control-label" for="filter20">Comercial</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" name="filtros[]" value="DY" class="custom-control-input" id="filter21">
              <label class="custom-control-label" for="filter21">DY  (faça você mesmo)</label>
            </div>
          </li>
        </ul>
      </div>
    </details>
    <div class="d-flex justify-content-between mt-2 g-10 flex-column flex-md-row flex-xl-row">
      <button type="button" class="btn btn-outline-secondary col-md-6" id="resetFilters">Limpar Filtros</button>
      <button type="submit" class="btn btn-primary col-md-6">Aplicar Filtros</button>
    </div>
  </form>
</div>


<!-- Arquivo JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('resetFilters').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.custom-control-input');
    checkboxes.forEach(function(checkbox) {
      checkbox.checked = false;
    });
  });
</script>
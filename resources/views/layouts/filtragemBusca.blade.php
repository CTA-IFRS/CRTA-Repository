<!-- Botão de Filtros visível apenas em telas pequenas -->
<button id="btn_filtros" class="btn btn-primary d-block d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtroDiv" aria-expanded="false" aria-controls="filtroDiv">
  Exibir Filtros
  <i class="fa fa-filter" aria-hidden="true"></i>
</button>

<!-- Box de filtros com colapso em telas pequenas -->
<div class="collapse d-md-block" id="filtroDiv">
  <div class="box-filtros bg-white rounded-lg p-3">
    <h4 class="d-none d-md-block">Filtros</h4>
    <hr class="d-none d-md-block">
    <details class="filter-category">
      <summary class="mb-2">Categoria 1</summary>
      <div class="filter-options">
        <ul>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" class="custom-control-input" id="filter1">
              <label class="custom-control-label" for="filter1">Lorem ipsum dolor</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" class="custom-control-input" id="filter2">
              <label class="custom-control-label" for="filter2">Lorem ipsum dolor</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" class="custom-control-input" id="filter3">
              <label class="custom-control-label" for="filter3">Lorem ipsum dolor</label>
            </div>
          </li>
        </ul>
      </div>
    </details>
    <details class="filter-category">
      <summary class="mb-2">Categoria 2</summary>
      <div class="filter-options">
        <ul>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" class="custom-control-input" id="filter4">
              <label class="custom-control-label" for="filter4">Lorem ipsum dolor</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" class="custom-control-input" id="filter5">
              <label class="custom-control-label" for="filter5">Lorem ipsum dolor</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-checkbox mr-2">
              <input type="checkbox" class="custom-control-input" id="filter6">
              <label class="custom-control-label" for="filter6">Lorem ipsum dolor</label>
            </div>
          </li>
        </ul>
      </div>
    </details>
  </div>
</div>


<!-- Arquivo JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

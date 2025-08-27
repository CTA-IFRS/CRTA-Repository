<!-- Botão de Filtros visível apenas em telas pequenas -->
<button id="btn_filtros" class="btn btn-primary d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtroDiv" aria-expanded="false" aria-controls="filtroDiv">
  Exibir Filtros
  <i class="fa fa-filter" aria-hidden="true"></i>
</button>

<?php 
    $isTagInArray = function ($tag, $array) {
      $tag = strtolower($tag);
      foreach ($array as $value) {
        if (strtolower($value) == $tag) return true;
      }    
      return false;
    }
?>

<!-- Box de filtros com colapso em telas pequenas -->
<div class="collapse d-lg-block" id="filtroDiv">
  <form class="box-filtros bg-white rounded p-4" method="post" action="{{route('filtroPost')}}">
    {{ csrf_field() }}
    <input type="hidden" name="texto" value="{{$parametro}}" />
    <h3 class="d-none d-lg-block">Filtros</h3>
    <hr class="d-none d-lg-block">
    <details class="filter-category">
      <summary class="mb-2">Tipo</summary>
      <div class="filter-options">
        <ul>
          <?php 
            $filtrosAplicados = (isset($filtros)) ? $filtros : [];
            $tipos = ["Tecnologia assistiva", "Material pedagógico"];
          ?>
          @foreach ($tipos as $k => $tipo) 
            <li>
              <div class="custom-control custom-checkbox mr-2">
                <input type="checkbox" name="filtros[]" value="{{$tipo}}" class="custom-control-input" id="filter{{$k}}" {{$isTagInArray($tipo, $filtrosAplicados) ? 'checked' : ''}}>
                <label class="custom-control-label" for="filter{{$k}}">{{$tipo}}</label>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </details>
    <details class="filter-category">
      <summary class="mb-2">Condição</summary>
      <div class="filter-options">
        <ul>
          <?php 
            $tamTipos = count($tipos);
            $condicoes = ["Baixa visão", "Deficiência visual", "Cegueira", "Deficiência auditiva", "Surdez", 
                          "Surdocegueira", "Deficiência física", "Deficiência intelectual",
                          "Autismo", "Neurodivergência"];
          ?>
          @foreach ($condicoes as $k => $condicao) 
            <li>
              <div class="custom-control custom-checkbox mr-2">
                <input type="checkbox" name="filtros[]" value="{{$condicao}}" class="custom-control-input" id="filter{{$tamTipos+$k}}" {{$isTagInArray($condicao, $filtrosAplicados) ? 'checked' : ''}}>
                <label class="custom-control-label" for="filter{{$tamTipos+$k}}">{{$condicao}}</label>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </details>
    <details class="filter-category">
      <summary class="mb-2">Necessidade</summary>
      <div class="filter-options">
        <ul>
          <?php 
            $tamCondicoes = count($condicoes) + count($tipos);
            $necessidades = ["Comunicação", "Mobilidade", "Braille", "Libras", "Leitor de tela", "Mouse", "Mouse adaptado", "Teclado",
                          "Material tátil", "Objeto de Aprendizagem", "Software"];
          ?>
          @foreach ($necessidades as $k => $necessidade) 
            <li>
              <div class="custom-control custom-checkbox mr-2">
                <input type="checkbox" name="filtros[]" value="{{$necessidade}}" class="custom-control-input" id="filter{{$k + $tamCondicoes}}" {{$isTagInArray($necessidade, $filtrosAplicados) ? 'checked' : ''}}>
                <label class="custom-control-label" for="filter{{$k + $tamCondicoes}}">{{$necessidade}}</label>
              </div>
            </li>
          @endforeach
          
        </ul>
      </div>
    </details>
    <details class="filter-category">
      <summary class="mb-2">Outros</summary>
      <div class="filter-options">
        <ul>
         <?php 
            $tamCondNess = count($tipos) + count($condicoes) + count($necessidades);
            $outros = ["Gratuito", "Baixo custo", "Comercial"];
          ?>
          @foreach ($outros as $k => $outro) 
            <li>
              <div class="custom-control custom-checkbox mr-2">
                <input type="checkbox" name="filtros[]" value="{{$outro}}" class="custom-control-input" id="filter{{$k + $tamCondNess}}" {{$isTagInArray($outro, $filtrosAplicados) ? 'checked' : ''}}>
                <label class="custom-control-label" for="filter{{$k + $tamCondNess}}">{{$outro}}</label>
              </div>
            </li>
          @endforeach
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

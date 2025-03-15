<div class="mt-5">
    <div id="listagem_recursos_paginacao" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 col-12 p-0">
        @foreach($recursosTA as $recursoTA)
        <div class="col mb-4" >
            <div class="card card-recurso-ta d-flex flex-column h-100">
                <!--tirar depois--><img class="card-img-top m-auto p-2 pt-3" src="https://cta-api.ifrs.edu.br/repositorio/storage/thumbnails/1640888757_Foto DarkReader.jpg" alt="Foto DarkReader">
                @foreach($recursoTA->fotos as $foto)
                @if($foto->destaque==true)
                <img class="card-img-top" src="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" alt="{{$foto->texto_alternativo}}">
                @endif
                @endforeach
                <div class="card-body">
                    <h3 class="card-title"><a href="{{route('exibeRecursoTASlug', $recursoTA->slug)}}" class="card-link">{{ $recursoTA->titulo }}</a></h3>
                    <p class="card-text">{{ html_entity_decode(substr(strip_tags($recursoTA->descricao), 0, 150), ENT_QUOTES, 'UTF-8')." ..." }}</p>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
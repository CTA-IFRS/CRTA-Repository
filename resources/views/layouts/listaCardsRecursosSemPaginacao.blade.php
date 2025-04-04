<!--recursos exibidos na página inicial-->
<div class="mt-4">
    <div class="listagem_recursos_sem_paginacao row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-5 p-0">
        @foreach($recursosTA as $recursoTA)
        <div class="col mb-4" >
            <div class="card card-recurso-ta d-flex flex-column h-100">
                @foreach($recursoTA->fotos as $foto)
                @if($foto->destaque==true)
                <img class="card-img-top m-auto p-2 pt-3" src="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" alt="{{$foto->texto_alternativo}}">
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

<script>

document.addEventListener('DOMContentLoaded', function() {

    const links = document.querySelectorAll('.card-link');

    links.forEach(link => {
        const h3 = link.closest('.card-title');

        link.addEventListener('focus', () => {
            h3.classList.add('focused');
        });

        link.addEventListener('blur', () => {
            h3.classList.remove('focused');
        });
    });
});

</script>
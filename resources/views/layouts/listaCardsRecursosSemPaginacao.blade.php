<!--recursos exibidos na página inicial e recurso interno-->
@foreach($recursosTA as $recursoTA)
<div class="col mb-4" >
    <div class="card card-recurso-ta d-flex flex-column h-100">
        @foreach($recursoTA->fotos as $foto)
        @if($foto->destaque==true)
        <div class="hoverImageWrapper m-2">
            <img class="hoverImage card-img-top" src="{{url(Storage::url('public/'.$foto->caminho_thumbnail))}}" alt="{{$foto->texto_alternativo}}">
        </div>
        @endif
        @endforeach
        <div class="card-body">
            <h3 class="card-title"><a href="{{route('exibeRecursoTASlug', $recursoTA->slug)}}" class="card-link">{{ $recursoTA->titulo }}</a></h3>
            <p class="card-text">{{ html_entity_decode(substr(strip_tags($recursoTA->descricao), 0, 150), ENT_QUOTES, 'UTF-8')." ..." }}</p>
        </div>

    </div>
</div>
@endforeach

<script>

document.addEventListener('DOMContentLoaded', function() {

    const links = document.querySelectorAll('.card-link');

    links.forEach(link => {
        const h3 = link.closest('.card-title');
        const card = link.closest('.card-recurso-ta');

        link.addEventListener('focus', () => {
            h3.classList.add('focused');
            card.classList.add('hover');
        });

        link.addEventListener('blur', () => {
            h3.classList.remove('focused');
            card.classList.remove('hover');
        });
    });
});

</script>
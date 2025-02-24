
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li>Você está em:&nbsp;</li>
        @foreach ($data as $item)
            @if (isset($item['link']))
                <li class="breadcrumb-item {{ (isset($item['active'])) ? 'active' : '' }}">
                    <a href="{{$item['link']}}">{{$item['name']}}</a>
                </li>        
            @else
                <li class="breadcrumb-item {{ isset($item['active']) ? 'active' : ''}}" 
                   >
                    {{$item['name']}}
                </li>        
            @endif
        @endforeach
    </ol>
</nav>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- A página que herdar esse layout deverá indicar o título -->
    <title>@yield('titulo')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/personalizacoes.css') }}" rel="stylesheet">
</head>
<body class="vh-100">
   <!-- A página que herdar esse layout deverá indicar se o banner será carregado e o conteudo dela-->
   <header>
   @include('layouts.menuNavegacaoSecundario')
   @include('layouts.menuNavegacaoPrincipal')
   </header>

   <main>
   @yield('bannerTelaInicial')

   @yield('conteudo')
   </main>
   
   <!-- Scripts -->
   <script src="{{ asset('js/app.js') }}" ></script>
   <script src="{{ __('https://use.fontawesome.com/9193d17150.js')}}"></script>
   <script src="{{__('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js')}}" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
   @yield('scripts')
   @include('layouts.rodape')
</body>
</html>
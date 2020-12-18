
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
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
    </head>
    <body class="skin-blue vh-100">
    	<!-- A página que herdar esse layout deverá indicar se o banner será carregado e o conteudo dela-->
    	@include('layouts.menuNavegacaoSecundario')
    	@include('layouts.menuNavegacaoAdmin')
        @yield('bannerTelaInicial')
        @yield('conteudo')
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ __('https://use.fontawesome.com/9193d17150.js')}}"></script>
        <script src="{{ __('https://code.jquery.com/ui/1.12.1/jquery-ui.js')}}"></script>
        @yield('scripts')
        @include('layouts.rodape')
    </body>
</html>
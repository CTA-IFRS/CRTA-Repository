
<!DOCTYPE html>
<html lang="pt-br">
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
    	@include('layouts.menuNavegacaoSecundario')
    	@include('layouts.menuNavegacaoPrincipal')
        @yield('bannerTelaInicial')
        @yield('conteudo')
        
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
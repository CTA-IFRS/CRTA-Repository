
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- A página que herdar esse layout deverá indicar o título -->
    <title>@yield('titulo')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (function () {
            var contrast = localStorage.getItem("contrast");
            document.documentElement.className = (contrast || "normal");
        })();
    </script>

    <!-- Estilos -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/personalizacoes.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{__('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css')}}" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="vh-100">
   <!-- A página que herdar esse layout deverá indicar se o banner será carregado e o conteudo dela-->
   <header>
   <a href="#conteudo-principal" class="sr-only">Ir para o conteúdo</a> 
   @include('layouts.menuNavegacaoSecundario')
   @include('layouts.menuNavegacaoPrincipal')
   </header>

   <a href="#" id="conteudo-principal" class="sr-only">Início do conteúdo</a>
   <main>
   @yield('bannerTelaInicial')

   @yield('conteudo')
   </main>
   <a href="#" class="sr-only">Final do conteúdo</a>
   
   <!-- Scripts -->
   <script src="{{ asset('js/app.js') }}" ></script>
   <script src="{{ __('https://use.fontawesome.com/9193d17150.js')}}"></script>
   <script src="{{__('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js')}}" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
   <script src="{{ __('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js')}}"></script>
   <script>
        $(document).ready(function() {
            (function (){
                var normalContrast = '<i class="fa fa-adjust" aria-hidden="true"></i><span class="sr-only">Mudar para o Contraste Normal</span>';
                var highContrast = '<i class="fa fa-adjust" aria-hidden="true"></i><span class="sr-only">Mudar para o Alto contraste</span>';

                $("#ativar-altocontraste").click(function (e) {
                    e.preventDefault();
                    var html = $(document.documentElement);
                    html.toggleClass("high-contrast");
                    if (html.hasClass("high-contrast")) {
                        $(this).html(normalContrast);
                        localStorage.setItem("contrast", "high-contrast");
                    } else {
                        $(this).html(highContrast);
                        localStorage.setItem("contrast", "normal");
                    }
                    
                });

                var contrast = localStorage.getItem("contrast");
                $("#ativar-altocontraste").html(
                    ((contrast === "high-contrast") ? normalContrast : highContrast)
                );
                
            })();
        });
    </script>
   @yield('scripts')

   <a href="#" id="inicio-rodape" class="sr-only">Início do rodapé</a>
   @include('layouts.rodape')
   <a href="#" class="sr-only">Final do rodapé</a>
</body>
</html>
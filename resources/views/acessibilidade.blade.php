@extends('layouts.siteLayout')
@section('titulo','RETACE - Acessibilidade')
@section('conteudo')
<div class="container container-xl mt-5">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
            ['name' => 'Acessibilidade', 'current' => true]
        ]
    ?>
    <div class="row breadcrumb-clear-pad">
        <div class="col">
            @include('layouts.breadcrumb', $data)
        </div>
    </div>
    <hr class="mt-0">
</div>

<div id="acessibilidade" class="custom_content container custom-container card my-3 bg-transparent">
	<div class="row">
        <div class="col-12">
            <div class="row">
                <h2 class="h1 m-auto pt-4">Acessibilidade</h2>
            </div>
        </div>
		<div id="conteudo" class="col-12 pt-4">
			<h3 class="mb-3">Acessibilidade de nosso site</h3>
            <p>De acordo com o&nbsp;<a class="link-primary" href="http://www.w3c.br/">W3C&nbsp;(World Wide Web Consortium)</a>, 
                Acessibilidade na Web significa garantir que todas as pessoas, incluindo pessoas com 
                defici&ecirc;ncia, possam utilizar a Web. Mais especificamente, significa permitir que 
                pessoas com defici&ecirc;ncia consigam perceber, compreender, navegar, interagir e contribuir
                 com a Web. Uma Web acess&iacute;vel beneficia a todos, incluindo pessoas idosas, pessoas com 
                 pouca habilidade em utilizar a Web, aqueles com uma conex&atilde;o mais lenta, entre outros.
            </p>

            <p>Em nosso site, seguimos as recomenda&ccedil;&otilde;es de acessibilidade dos documentos&nbsp;
                <a class="link-primary" href="https://www.w3c.br/traducoes/wcag/wcag21-pt-BR/">WCAG 2.1&nbsp;(Web Content Accessibility Guidelines ou Diretrizes de Acessibilidade para 
                Conte&uacute;do Web &ndash; internacional)</a> 
                 e <a class="link-primary" href="http://emag.governoeletronico.gov.br/">eMAG 3.1&nbsp;(Modelo de Acessibilidade em Governo Eletr&ocirc;nico &ndash; nacional)</a>.
            </p>
            
            <p>
                <b>No topo das p&aacute;ginas de nosso site, disponibilizamos uma barra de acessibilidade, que cont&eacute;m:</b>
            </p>
            
            <ul class="d-flex flex-column p-0 pt-2">
                <li class="bg-white d-flex rounded-lg">
                    <div class="row w-100 m-0 py-3 py-sm-4 px-1 px-sm-3">
                        <div class="col-12 d-flex flex-column">
                            <strong class="mb-2">Atalhos de teclado</strong>
                            Permitem ir diretamente a um bloco do site, 
                            facilitando a navega&ccedil;&atilde;o para quem utiliza o teclado, como pessoas cegas e 
                            com certas limita&ccedil;&otilde;es f&iacute;sicas.
                        </div>
                    </div>
                </li>
                <li class="bg-white d-flex rounded-lg">
                    <div class="row w-100 m-0 py-3 py-sm-4 px-1 px-sm-3">
                        <div class="col-md-7 col-12 d-flex flex-column">
                            <strong class="mb-2">P&aacute;gina de acessibilidade</strong>
                            Apresenta informa&ccedil;&otilde;es sobre 
                            a acessibilidade do site, recursos oferecidos e testes realizados;
                        </div>
                        <div class="col-md-5 col-12 mt-3 mt-md-0">
                        <img src="{{url('/imagens/pag_acessibilidade.png')}}" alt="imagem mostrando a página de acessibilidade" class="img-fluid rounded">
                        </div>
                    </div>
                </li>
                <li class="bg-white d-flex rounded-lg">
                    <div class="row w-100 m-0 py-3 py-sm-4 px-1 px-sm-3">
                        <div class="col-md-7 col-12 d-flex flex-column">
                            <strong class="mb-2">Mapa do site</strong>
                            Disponibiliza todas as p&aacute;ginas do site de 
                            forma hier&aacute;rquica, permitindo que o usu&aacute;rio conhe&ccedil;a toda a estrutura 
                            do site e acesse diretamente a p&aacute;gina desejada.
                        </div>
                        <div class="col-md-5 col-12 mt-3 mt-md-0">
                            <img src="{{url('/imagens/mapa_site.png')}}" alt="imagem mostrando o menu com o mapa do site" class="img-fluid rounded">
                        </div>
                    </div>
                </li>
            </ul>

            <h3 class="mt-5 mb-3">Utilizando os atalhos</h3>
            <p>
                <b>Em nosso site, disponibilizamos quatro atalhos de teclado:</b>
            </p>
            <ul>
                <li>1: Ir para o conte&uacute;do</li>
                <li>2: Ir para o menu</li>
                <li>3: Ir para busca</li>
                <li>4: Ir para rodap&eacute;</li>
            </ul>

            <p>
                <b>Cada navegador possui tecla ou teclas espec&iacute;ficas para ativar os atalhos:</b>
            </p>
            <ul>
                <li>Chrome:&nbsp;<strong>Alt + [n&uacute;mero do atalho]</strong>&nbsp;(Windows/Linux) 
                    ou&nbsp;<strong>Control + Option + [n&uacute;mero do atalho]</strong>&nbsp;(Mac)
                </li>
                <li>Firefox:&nbsp;<strong>Alt + Shift + [n&uacute;mero do atalho]</strong>&nbsp;(Windows/Linux) 
                    ou&nbsp;<strong>Control + Option + [n&uacute;mero do atalho]</strong>&nbsp;(Mac)
                </li>
                <li>Internet Explorer 8+:&nbsp;<strong>Alt + [n&uacute;mero do atalho]</strong>&nbsp;(Windows/Linux) 
                    ou&nbsp;<strong>Control + [n&uacute;mero do atalho]</strong>&nbsp;(Mac)
                </li>
                <li>Safari 4+:&nbsp;<strong>Alt + [n&uacute;mero do atalho]</strong>&nbsp;(Windows/Linux) 
                    ou&nbsp;<strong>Control + Option + [n&uacute;mero do atalho]</strong>&nbsp;(Mac)
                </li>
            </ul>
            
            <h3 class="mt-5 mb-3">Ampliando o texto no navegador</h3>
            <ul>
                <li>Pressione&nbsp;<strong>&ldquo;Ctrl&rdquo;</strong>&nbsp;+&nbsp;<strong>&ldquo;+&rdquo;</strong>&nbsp;
                    (sinal de mais) para aumentar a fonte do texto;
                </li>
                <li>Pressione&nbsp;<strong>&ldquo;Ctrl&rdquo;</strong>&nbsp;+&nbsp;<strong>&ldquo;-&rdquo;</strong>&nbsp;
                    (sinal de menos) para diminuir a fonte do texto;
                </li>
                <li>Pressione&nbsp;<strong>&ldquo;Ctrl&rdquo;</strong>&nbsp;+&nbsp;<strong>&ldquo;0&rdquo;</strong>&nbsp;(zero) 
                    para retornar ao tamanho padr&atilde;o da fonte.
                </li>
            </ul>
            
            <p>No Mac OS, substitua o &ldquo;Ctrl&rsquo; pela tecla &ldquo;Command&rdquo;.</p>
            <br>

            <div class="card bg-secondary px-sm-5 px-3 py-sm-4 py-2 mb-4">
                <h3 class="mt-2 mb-4">Avalia&ccedil;&atilde;o de acessibilidade</h3>
                <p>
                    <b>&Uacute;ltima avalia&ccedil;&atilde;o autom&aacute;tica de acessibilidade realizada no site: maio/2021.</b>
                </p>
                <ul>
                    <li>Avalia&ccedil;&atilde;o autom&aacute;tica utilizando o 
                        <a class="link-primary" href="https://accessmonitor.acessibilidade.gov.pt/">
                        avaliador autom&aacute;tico AccessMonitor</a> (WCAG 2.1): &Iacute;ndice 8.8.
                    </li>
                </ul>
                
                <p>
                    <b>&Uacute;ltima avalia&ccedil;&atilde;o manual de acessibilidade realizada no site: --/2021.</b>
                </p>
                <ul>
                    <li>Avalia&ccedil;&atilde;o manual, atrav&eacute;s de testes de usu&aacute;rios com baixa 
                        vis&atilde;o e usu&aacute;rios cegos, utilizando leitores de tela NVDA e VoiceOver, e testes 
                        realizados por desenvolvedores com experi&ecirc;ncia em acessibilidade na web.
                    </li>
                </ul>
            </div>
            
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {

	});
</script>
@endsection
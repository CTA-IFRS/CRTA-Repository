@extends('layouts.siteLayout')
@section('titulo','RETACE - Acessibilidade')
@section('conteudo')
<div class="container mt-5">
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
</div>

<div class="container card my-3">
	<div class="row">
        <div class="col-12">
            <div class="row">
                <h2 class="display-3 pl-4 h1">Acessibilidade</h2>
            </div>
        </div>
		<div id="conteudo" class="col-12 pt-5 pl-5" >
			<h3>Acessibilidade de nosso site</h3>
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
            
            <p>No topo das p&aacute;ginas de nosso site, disponibilizamos uma barra de acessibilidade, que cont&eacute;m:</p>
            <ul>
                <li><strong>Atalhos de teclado:</strong>&nbsp;permitem ir diretamente a um bloco do site, 
                    facilitando a navega&ccedil;&atilde;o para quem utiliza o teclado, como pessoas cegas e 
                    com certas limita&ccedil;&otilde;es f&iacute;sicas;
                </li>
                <li><strong>P&aacute;gina de acessibilidade:</strong>&nbsp;apresenta informa&ccedil;&otilde;es sobre 
                    a acessibilidade do site, recursos oferecidos e testes realizados;
                </li>
                <li><strong>Mapa do site:</strong>&nbsp;disponibiliza todas as p&aacute;ginas do site de 
                    forma hier&aacute;rquica, permitindo que o usu&aacute;rio conhe&ccedil;a toda a estrutura 
                    do site e acesse diretamente a p&aacute;gina desejada.
                </li>
            </ul>

            <h3>Utilizando os atalhos</h3>
            <p>Em nosso site, disponibilizamos quatro atalhos de teclado:</p>
            <ul>
                <li>1: Ir para o conte&uacute;do</li>
                <li>2: Ir para o menu</li>
                <li>3: Ir para busca</li>
                <li>4: Ir para rodap&eacute;</li>
            </ul>

            <p>Cada navegador possui tecla ou teclas espec&iacute;ficas para ativar os atalhos:</p>
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
            
            <h3>Ampliando o texto no navegador</h3>
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

            <h3>Avalia&ccedil;&atilde;o de acessibilidade</h3>
            <p>&Uacute;ltima avalia&ccedil;&atilde;o autom&aacute;tica de acessibilidade realizada no site: maio/2021.</p>
            <ul>
                <li>Avalia&ccedil;&atilde;o autom&aacute;tica utilizando o 
                    <a class="link-primary" href="https://accessmonitor.acessibilidade.gov.pt/">
                    avaliador autom&aacute;tico AccessMonitor</a> (WCAG 2.1): &Iacute;ndice 8.8.
                </li>
            </ul>
            
            <p>&Uacute;ltima avalia&ccedil;&atilde;o manual de acessibilidade realizada no site: --/2021.</p>
            <ul>
                <li>Avalia&ccedil;&atilde;o manual, atrav&eacute;s de testes de usu&aacute;rios com baixa 
                    vis&atilde;o e usu&aacute;rios cegos, utilizando leitores de tela NVDA e VoiceOver, e testes 
                    realizados por desenvolvedores com experi&ecirc;ncia em acessibilidade na web.
                </li>
            </ul>
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
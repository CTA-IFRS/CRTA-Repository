@extends('layouts.siteLayout')
@section('titulo','RETACE - Sobre')
@section('conteudo')

<div class="container container-xl mt-5">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
            ['name' => 'Sobre', 'current' => true]
        ]
    ?>
    <div class="row breadcrumb-clear-pad">
        <div class="col">
            @include('layouts.breadcrumb', $data)
        </div>
    </div>
    <hr class="mt-0">
</div>
<div id="" class="custom_content container custom-container card my-3 bg-transparent">
	<div class="row">
        <div class="col-12">
            <div class="row">
                <h2 class="h1 m-sm-auto pt-4 ml-3">Sobre o RETACE</h2>
            </div>
        </div>
        
		<div id="conteudo" class="col-12 pt-2 pl-sm-2 py-0">
			<div class="mt-sm-4 mb-sm-3 mt-1">
				<p class="frase-inicial text-sm-center">O RETACE é um repositório de Tecnologia Assistiva, vinculado ao contexto da educação, com o objetivo de permitir que os usuários encontrem possibilidades de tecnologia assistiva e todas as informações referentes a cada recurso em um só local.</p>
                <br>
                <h3>Buscando um recurso</h3>
                <p>A busca pode ser realizada por termo ou por categoria. Ainda, através do menu, é possível acessar todos os recursos de Tecnologia Assistiva, bem como os materiais pedagógicos acessíveis cadastrados.</p>
                <br>
                <h3>Acessando um recurso</h3>
                <p>Ao acessar um recurso, são disponibilizadas diversas informações, tais como: descrição do recurso, imagens e/ou vídeos relacionados; manuais de desenvolvimento (quando for o caso) e de uso, além de recursos relacionados. Também são disponibilizadas informações sobre fabricante/desenvolvedor, licença, número de visitas e avaliações.</p>
                <img class="img-fluid rounded shadow-sm mt-4" src="{{url('/imagens/sobre_img1.jpg')}}" alt="imagem mostrando o menu com o mapa do site">
                <div class="bg-blue frase_destaque p-3 p-sm-4 rounded-lg my-5">
                    <span class="aspas"></span>
                    <p class="m-0 my-5 text-center">O intuito do RETACE é permitir que os usuários<br> <b>encontrem possibilidades de tecnologia assistiva</b><br> e todas as informações referentes a cada recurso em um só local.</p>
                </div>
                <div class="row w-100 m-0" id="aprender_contribuir">
                    <div class="d-flex flex-column justify-content-between bg-white px-sm-4 px-3 py-4 rounded-lg">
                        <div>
                            <h3 class="text-left">Quer CONTRIBUIR com algum recurso?</h3>
                            <p>A área CONTRIBUIR do repositório permite que qualquer pessoa possa incluir recursos de Tecnologia Assistiva ainda não cadastrados no repositório.</p>
                        </div>
                        <img class="img-fluid rounded mt-sm-3 mt-2" src="{{url('/imagens/sobre_img2.jpg')}}" alt="imagem mostrando o menu com o mapa do site">
                    </div>
                    <div class="d-flex flex-column justify-content-between bg-white px-sm-4 px-3 py-4 rounded-lg">
                        <div>
                            <h3>Quer APRENDER sobre Tecnologia Assistiva?</h3>
                            <p>Na área APRENDER do repositório você encontra cursos, publicações e outros materiais que possibilitem aprender mais sobre Tecnologia Assistiva e sua aplicabilidade no contexto educacional.</p>
                        </div>
                        <img class="img-fluid rounded mt-sm-3 mt-2" src="{{url('/imagens/sobre_img3.jpg')}}" alt="imagem mostrando o menu com o mapa do site">
                    </div>
                </div>
                <div class="mx-auto mt-5 mb-5 historico">
                    <h3>Histórico do RETACE</h3>
                    <p>O RETACE foi desenvolvido e é gerenciado pelo Centro Tecnológico de Acessibilidade (CTA) do Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Sul (IFRS).<br><br>A criação do repositório teve início durante o Projeto Centro de Referência em Tecnologia Assistiva (CRTA), que teve financiamento da Secretaria de Educação Profissional e Tecnológica (SETEC) do Ministério da Educação (MEC), que teve como objetivo disseminar conhecimentos sobre o uso e o desenvolvimento de Tecnologia Assistiva de baixo custo e produção de materiais didático-pedagógicos acessíveis. Participaram do projeto, além do Centro Tecnológico de Acessibilidade - CTA (Reitoria) os campi do IFRS Bento Gonçalves, Caxias do Sul, Farroupilha, Porto Alegre, Restinga e Rio Grande.</p>
                </div>
			</div>		
		</div>
	</div>
</div>
<!--div class="container card my-3">
	<div class="row">
        @if ($conteudoPagina->texto == '')
            <div class="col-12">
                <div class="row">
                    <h2 class="display-3 pl-4 h1">Sobre</h2>
                </div>
                <div class="row">
                    <p class="lead pl-4">Saiba mais sobre o RETACE</p> 
                </div>
            </div>
        @endif

		<div id="conteudo" class="col-12 pt-2 pl-2" >
			<h3 class="display-4 h1 text-center mt-3 mb-5 ml-5 mr-5">
				{!! html_entity_decode(stripslashes($conteudoPagina->titulo_texto), ENT_QUOTES, 'UTF-8')!!} 
			</h3>
			<div class="my-3 ml-5 mr-5">
				{!! html_entity_decode(stripslashes($conteudoPagina->texto), ENT_QUOTES, 'UTF-8')!!}			
			</div>		
		</div>
	</div>
</div-->
@endsection
@section('scripts')
<script>
	$(document).ready(function() {

	});
</script>
@endsection
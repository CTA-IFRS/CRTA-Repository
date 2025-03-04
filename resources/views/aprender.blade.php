@extends('layouts.siteLayout')
@section('titulo','RETACE - Aprender')
@section('conteudo')

<div class="container container-xl mt-5">
	<?php 
        $data = [
            ['name' => 'RETACE', 'link' => url('/')],
            ['name' => 'Aprender', 'current' => true]
        ]
    ?>
    <div class="row breadcrumb-clear-pad">
        <div class="col">
            @include('layouts.breadcrumb', $data)
        </div>
    </div>
    <hr class="mt-0">
</div>

<div id="conteudo_aprender" class="custom_content container custom-container card my-3 bg-transparent">
	<div class="row">
        
		<div id="conteudo" class="col-12 p-0">
			<h2 class="display-4 h1 mt-3 mb-4">
				Aprender 
			</h2>
			<div class="my-3">
				<p dir="ltr"><span style="font-size: 14pt;">Se você deseja aprender sobre tecnologia assistiva, principalmente com foco no contexto educacional, disponibilizamos cursos e materiais gratuitos sobre o tema.
                    <br><br>
                    Os cursos são gratuitos, sem tutoria, geram certificado e são ofertados pela plataforma Moodle do Instituto Federal do Rio Grande do Sul (IFRS). Para se inscrever, é preciso ter cadastro no Moodle do IFRS. Se você ainda não tem cadastro, será preciso criar uma conta.</span>
                </p>
                <nav id="navegacaoCategorias" class="navbar navbar-expand-lg navbar-light bg-transparent">
                    <div class="collapse navbar-collapse justify-content-center pb-3" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <button class="nav-link" id="mostrarTudoBtn" onclick="mostrarTudo()">Tudo</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="cursosBtn" onclick="mostrarCursos()">Cursos</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="publicacoesBtn" onclick="mostrarPublicacoes()">Publicações</button>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="card curso p-4 mt-1 mb-4" style="border-left: 10px #d3ddea solid;">
                    <div class="row">
                    <span class="badge bg-blue position-absolute">curso</span>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a style="color: #267ab4;" href="https://moodle.ifrs.edu.br/enrol/index.php?id=4954" target="_blank" rel="noopener">Tecnologia Assistiva no Contexto Educacional</a></h3>
                            <p dir="ltr">O curso apresenta conceitos, recursos e serviços de tecnologia assistiva aplicados ao contexto educacional, enfatizando recursos gratuitos ou de baixo custo.</p>
                            <p><b>Módulos:</b>&nbsp;</p>
                            <ul>
                                <li dir="ltr">Módulo 1 – A Tecnologia Assistiva (TA)</li>
                                <li dir="ltr">Módulo 2 – Recursos de TA no contexto educacional</li>
                                <li dir="ltr">Módulo 3 – Serviços de TA no contexto educacional</li>
                            </ul>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Carga horária: 60h</b></p>
                                <p class="mr-5"><b>Nível: básico</b></p>
                            </div>
                        </div>
                        <div class="col-3 d-flex"><img class="img-fluid m-auto" src="{{url('/imagens/icon_curso1.png')}}" alt=""></div>
                    </div>
                </div>
                <div class="card curso p-4 mt-1 mb-4" style="border-left: 10px #d3ddea solid;">
                    <div class="row">
                    <span class="badge bg-blue position-absolute">curso</span>
                        <div class="col-9 pr-5">
                        <h3 dir="ltr"><a style="color: #267ab4;" href="https://moodle.ifrs.edu.br/enrol/index.php?id=4946" target="_blank" rel="noopener">Possibilidades para a fabricação digital de recursos de Tecnologia Assistiva de Baixo Custo na educação</a></h3>
                            <p dir="ltr">O curso tem como objetivo principal apresentar conceitos sobre movimento maker e fabricação digital, apresentando possibilidades de seu uso para a prototipagem de recursos de apoio personalizados para estudantes com deficiência ou outras limitações.&nbsp;</p>
                            <p class="mb-0"><b>Unidades:</b>&nbsp;</p>
                            <ul>
                                <li dir="ltr">Unidade 1 – Conhecendo o que é movimento maker e fabricação digital&nbsp;</li>
                                <li dir="ltr">Unidade 2 – Espaços makers e equipamentos de fabricação digital&nbsp;</li>
                                <li dir="ltr">Unidade 3 – Tecnologia Assistiva (TA)&nbsp;</li>
                                <li dir="ltr">Unidade 4 – Possibilidades para a fabricação de recursos de TA de Baixo Custo na educação&nbsp;</li>
                                <li dir="ltr">Unidade 5 – Para além do processo de fabricação de recursos de TA&nbsp;</li>
                            </ul>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Carga horária: 40h</b></p>
                                <p class="mr-5"><b>Nível: básico</b></p>
                            </div>
                        </div>
                        <div class="col-3 d-flex"><img class="img-fluid m-auto" src="{{url('/imagens/icon_curso2.png')}}" alt=""></div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/conexoes-assistivas.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/1_BM6zQywOF1XtAiU45MmOcAh9_2PgRoI/view" target="_blank" rel="noopener">Conexões Assistivas: Tecnologia Assistiva e Materiais Didáticos Acessíveis</a></h3>
                            <p dir="ltr">&nbsp;É um produto do projeto Centro de Referência em Tecnologia Assistiva (CRTA), que tem como objetivo principal disseminar para toda a Rede Federal de EPCT os conhecimentos sobre o uso e o desenvolvimento de Tecnologia Assistiva (TA), com base no conceito estabelecido na Lei Nº 13.146/2015 e nas experiências do Centro Tecnológico de Acessibilidade (CTA) na pesquisa, elaboração e legitimação de recursos para serem utilizados no processo de ensino e aprendizagem de pessoas com necessidades educacionais específicas.&nbsp;</p>
                            <p dir="ltr"><b>Organizadores:</b> Andréa Poletto Sonza, Bruna Poletto Salton, Silvia de Castro Bertagnolli, Lael Nervis e Lucas Coradini</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2020</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/afirmar.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/1eTHcEJm7oykouKkg5-GFBKATAlEUWXp1/view" target="_blank" rel="noopener">AFIRMAR – A inclusão e as diversidades no IFRS: ações e reflexões</a></h3>
                            <p dir="ltr">Traz um panorama de práticas e ações relacionadas às políticas de ações afirmativas, inclusivas e de diversidade propostas pelo Instituto Federal do Rio Grande do Sul (IFRS), que são pilares importantes do Projeto Pedagógico Institucional. O livro traz dois capítulos sobre tecnologia assistiva no contexto educacional:</p>
                            <ul>
                                <li dir="ltr">Capítulo 21: A Tecnologia Assistiva e sua Aplicação no Contexto Educacional: Proposta de Estratégias e Metodologia para Uso, Análise e Desenvolvimento de Recursos.</li>
                                <li dir="ltr">Capítulo 22: A Tecnologia Assistiva e sua Aplicação no Contexto Educacional: Exemplos.</li>
                            </ul>
                            <p dir="ltr"><b>Organizadores:</b> Andréa Poletto Sonza, Helen Scorsatto Ortiz, Luciano Nascimento Corsino, Marlise Paz dos Santos, Rosângela Ferreira, Sandro Ouriques Cardoso</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2020</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/reflexões.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/1yecsiaMZKwTQhkC_En-zWaU8OqG8ErvV/view" target="_blank" rel="noopener">Reflexões sobre o Currículo Inclusivo</a></h3>
                            <p dir="ltr">Aborda conceitos relevantes vinculados às adaptações curriculares, retratando algumas das importantes ações realizadas em prol de um currículo verdadeiramente inclusivo.</p>
                            <p dir="ltr"><b>Organizadores:</b> Andréa Poletto Sonza, Bruna Poletto Salton e Anderson Dall’Agnol</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2018</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/manual.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/1prnE3MJfTsxARpWR2cOLbWmtK3x6aLNt/view" target="_blank" rel="noopener">Manual de Acessibilidade em Documentos Digitais</a></h3>
                            <p dir="ltr">Surge para atender a demandas crescentes, tanto daqueles que encontram barreiras de acesso e utilização no meio digital, quanto dos que desejam trabalhar para a garantia de um mundo digital mais inclusivo, de modo que ele traga possibilidades e quebra de barreiras, que seja um facilitador na vida de todas as pessoas, inclusive das com alguma deficiência ou outras especificidades.</p>
                            <p dir="ltr"><b>Organizadores:</b> Bruna Poletto Salton, Anderson Dall Agnol, Alissa Turcatti</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2017</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/uso-pedagogico.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/1MMQrZX7LtFIS4eGCCY5IlZmRe0RMDgiR/view" target="_blank" rel="noopener">O Uso Pedagógico dos Recursos de Tecnologia Assistiva</a></h3>
                            <p dir="ltr">É fruto de nossa terceira edição do curso de aperfeiçoamento “O uso pedagógico dos recursos de Tecnologia Assistiva”, o qual faz parte das ações da Rede Nacional de Formação Continuada dos Profissionais do Magistério da Educação Básica Pública (RENAFORM), subsidiado pela Secretaria de Educação Continuada, Alfabetização, Diversidade e Inclusão (SECADI) do Ministério da Educação – MEC.</p>
                            <p dir="ltr"><b>Organizadores:</b> Andréa Poletto Sonza, Bruna Poletto Salton, Jair Adriano Strapazzon</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2015</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/soluções.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/17CuUwrkrEQHJ8PKicd62oR98at0vokLG/view" target="_blank" rel="noopener">Soluções Acessíveis: experiências inclusivas no IFRS</a></h3>
                            <p dir="ltr">O livro engloba diversos artigos nas áreas de inclusão e acessibilidade.</p>
                            <p dir="ltr"><b>Organizadores:</b> Andréa P. Sonza, Bruna P. Salton e Jair A. Strapazzon</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2014</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card publicacao p-4 mt-1 mb-4" style="border-left: 10px #e2d3ea solid;">
                    <div class="row">
                    <span class="badge bg-purple position-absolute">publicação</span>
                        <div class="col-3 p-0"><img class="img-fluid col-12" src="{{url('/imagens/acessibilidade.png')}}" alt="capa do livro"></div>
                        <div class="col-9 pr-5">
                            <h3 dir="ltr"><a href="https://drive.google.com/file/d/1wtpwN4govndQFhGOYwtHnCVZ3bCegrJ0/view" target="_blank" rel="noopener">Acessibilidade e Tecnologia Assistiva: Pensando a Inclusão Sociodigital de Pessoas com Necessidades Especiais</a></h3>
                            <p dir="ltr">O livro discorre sobre a acessibilidade e as tecnologias assistivas, tentando tornar as etapas do processo de inclusão mais claras para os educadores ou apenas auxiliando quem têm interesse em adquirir um pouco mais de conhecimento nesta área.</p>
                            <p dir="ltr"><b>Organizadores:</b> Andréa Poletto Sonza, Adrovane Kade, Agebson Façanha, André Luiz Andrade Rezende, Gleison Samuel do Nascimento, Maurício Covolan Rosito, Sirlei Bortolini, Woquiton Lima Fernandes</p>
                            <hr>
                            <div class="row m-0">
                                <p class="mr-5"><b>Ano da publicação: 2013</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <p>&nbsp;</p>
			</div>		
		</div>
	</div>
</div>

<!--div class="container card my-3">
	<div class="row">
        @if ($conteudoPagina->texto == '')
            <div class="col-12">
                <div class="row">
                    <h2 class="display-3 pl-4 h1">Aprender</h2>
                </div>
                <div class="row">
                    <p class="lead pl-4">Acesse materiais para estudar mais sobre Tecnologias Assistivas</p> 
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
<script>
    const mostrarTudoBtn = document.getElementById('mostrarTudoBtn');
    const cursosBtn = document.getElementById('cursosBtn');
    const publicacoesBtn = document.getElementById('publicacoesBtn');
    const cursos = document.querySelectorAll('.card.curso');
    const publicacoes = document.querySelectorAll('.card.publicacao');

    function mostrarTudo() {
        cursos.forEach(card => {
            card.style.display = 'flex';
        });
        publicacoes.forEach(card => {
            card.style.display = 'flex';
        });
    }

    function mostrarCursos() {
        cursos.forEach(card => {
            card.style.display = 'flex';
        });
        publicacoes.forEach(card => {
            card.style.display = 'none';
        });
    }

    function mostrarPublicacoes() {
        cursos.forEach(card => {
            card.style.display = 'none';
        });
        publicacoes.forEach(card => {
            card.style.display = 'flex';
        });
    }

</script>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {

	});
</script>
@endsection
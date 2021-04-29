<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\RecursoTA;
use App\Tag;
use App\Pagina;
use Embed\Embed;
/**
 * Classe para efetuar a navegação entre as páginas do RETACE
 */

class NavegacaoController extends Controller{
	/** 
	 * Exibe a tela inicial
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function inicio(Request $request){
		//Necessário para popular as tags existentes no DB
		$tagsCadastradas = Tag::where('publicacao_autorizada',true)->pluck('nome');
		
		$recursosMaisAcessados = RecursoTA::where('publicacao_autorizada',true)->orderBy('visualizacoes', 'desc')->get();//RecursoTA::all()->sortByDesc("visualizacoes");
		$oitoRecursosMaisAcessados = collect($recursosMaisAcessados)->take(8);

		$recursosMaisRecentes =  RecursoTA::where('publicacao_autorizada',true)->orderBy('visualizacoes', 'desc')->get();
		$oitoRecursosMaisRecentes = collect($recursosMaisRecentes)->take(8);
		return view('inicio',['listagemDeMaisRelevantes' => false, 
								'recursosMaisAcessados' => $oitoRecursosMaisAcessados, 
								'recursosMaisRecentes' => $oitoRecursosMaisRecentes,
								'tagsCadastradas' => $tagsCadastradas
				    ]);
	}

	/** 
	 * Efetua a busca por TAG e então exibe a tela com o resultado da busca
	 *	@param $tag que servirá como parâmetro de busca
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaRecursoTAPorTag(Request $request,$tag){
		//Necessário para popular as tags existentes no DB
		$tagsCadastradas = Tag::where('publicacao_autorizada',true)->pluck('nome');

		$arrayTagsInformadas = explode(",",$tag);


		//Busca por todos os recursos TAs que possuem as mesmas tags que o recurso a ser exibido
		$resultadoBusca = new Collection();
		
		foreach ($arrayTagsInformadas as $tagInformada) {
			$auxTag = Tag::firstWhere('nome',$tagInformada);

			$resultadoBusca = $resultadoBusca->merge($auxTag->recursosTA);					
		}
		//Remove duplicatas originadas por TAs em mais de uma tag
		$conjuntoOrdenado = $resultadoBusca->unique('id')->sortBy('attributes.visualizacoes');
		
		return view('buscaRecursoTA',[ 'tagsCadastradas' => $tagsCadastradas, 'buscaPorTag' => true, 'parametro' => $arrayTagsInformadas, 'recursosTA' => $conjuntoOrdenado]);
	}

	/** 
	 * Efetua a busca por termo e então exibe a tela com o resultado da busca
	 *	@param $termo que servirá como parâmetro de busca
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaRecursoTAPorTermo(Request $request,$termo){
		//Necessário para popular as tags existentes no DB
		$tagsCadastradas = Tag::where('publicacao_autorizada',true)->pluck('nome');

		$arrayTermos = explode(" ", $termo);
		
		//Busca por todos os recursos TAs que possuem as mesmas tags que o recurso a ser exibido
		$resultadoBusca = new Collection();

		foreach ($arrayTermos as $termoInformado) {
			$recursosTA =  RecursoTA::where('publicacao_autorizada',true)
				  ->where('recursos_ta.titulo', 'LIKE', "%$termoInformado%")
                  ->orWhere('recursos_ta.descricao', 'LIKE', "%$termoInformado%")->get();
            $resultadoBusca = $resultadoBusca->merge($recursosTA);     
		}

		//Remove duplicatas originadas por TAs em mais de uma tag
		$conjuntoOrdenado = $resultadoBusca->unique('id')->sortBy('attributes.visualizacoes');
		
		return view('buscaRecursoTA',[ 'tagsCadastradas' => $tagsCadastradas, 'buscaPorTag' => false,'parametro' => $termo, 'recursosTA' => $conjuntoOrdenado]);
	}

	/** 
	 * Efetua a busca por todos os recursos TA
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaPorTodosRecursosTA(Request $request){
		//Necessário para popular as tags existentes no DB
		$tagsCadastradas = Tag::where('publicacao_autorizada',true)->pluck('nome');

		$recursosTA = RecursoTA::where('publicacao_autorizada',true)->get();
		return view('buscaRecursoTA',[ 'tagsCadastradas' => $tagsCadastradas, 'buscaPorTag' => false,'parametro' => 'Todos os recursos', 'recursosTA' => $recursosTA]);		
	}

	/** 
	 * Exibe a tela de login 
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */
	public function login(){
		return view('auth.login');
	}


	/** 
	 * Exibe a tela de cadastro
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */
	/*
	public function cadastroUsuario(){
		return view('auth.register');
	}*/

	/** 
	 * Exibe a tela do painel do administrador
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */
	public function painelAdministrador(){
		return view('painelAdministrador');
	}

	/** 
	 * Exibe a tela de cadastro de Tecnologia Assistiva
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function cadastroTA(){
		return view('cadastrarTA');
	}

	/** 
	 * Exibe um Recurso de Tecnologia Assistiva em específico
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function exibeRecursoTA($idRecursoTA){
		$recursoTA = RecursoTA::findOrFail($idRecursoTA);
		RecursoTA::where('id', $idRecursoTA)->increment('visualizacoes', 1);

		//Busca por todos os recursos TAs que possuem as mesmas tags (já autorizadas)que o recurso a ser exibido
		$recursosRelacionados = new Collection();
		foreach ($recursoTA->tags as $tag) {
			if($tag->publicacao_autorizada==true){
				$recursosRelacionados = $recursosRelacionados->merge(
					$tag->recursosTA->filter(function ($recurso, $k) {
						return $recurso->publicacao_autorizada;
					})
				);
			}
		}
		//Ordena os recursos obtidos pela quantidade de visualizações
		$conjuntoOrdenado = $recursosRelacionados->unique('titulo')->sortBy('attributes.visualizacoes');
		//Pega os primeiros 4 para exibir como recursos relacionados
		$quatroRelacionadosMaisVistos = collect($conjuntoOrdenado)->take(4);

		$mediaAvaliacao = 0;
		$mediaAvaliacao = $recursoTA->userAverageRating;

		//Utiliza o package Embed para obter a url que permita esse tipo de uso
		$infoTodosVideos = Array();
		foreach ($recursoTA->videos as $video) {
			$infoVideo = Embed::create($video->url);
			array_push($infoTodosVideos,$infoVideo);
		}

		return view('exibeRecursoTA',
					['recursoTA' => $recursoTA, 
					'mediaAvaliacao' => $mediaAvaliacao,
					'recursosTA' =>$quatroRelacionadosMaisVistos,
					'informacoesVideos' => $infoTodosVideos]);
	}

	/** 
	 * Encaminha o navegador para a página "Aprender"
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function exibePaginaAprender(){

		$conteudoPagina = Pagina::where('nome','Aprender')->firstOrFail();
		return view('aprender', ['conteudoPagina' => $conteudoPagina]);
	}			


	/** 
	 * Encaminha o navegador para a página "Sobre"
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function exibePaginaSobre(){

		$conteudoPagina = Pagina::where('nome','Sobre')->firstOrFail();
		return view('sobre', ['conteudoPagina' => $conteudoPagina]);
	}		
}
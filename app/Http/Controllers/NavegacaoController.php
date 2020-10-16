<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\RecursoTA;
use App\Tag;
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
		
		$recursosMaisAcessados = RecursoTA::all()->sortByDesc("visualizacoes");
		$oitoRecursosMaisAcessados = collect($recursosMaisAcessados)->take(8);

		$recursosMaisRecentes = RecursoTA::all()->sortByDesc("created_at");
		$oitoRecursosMaisRecentes = collect($recursosMaisRecentes)->take(8);
		return view('inicio',['listagemDeMaisRelevantes' => false, 
								'recursosMaisAcessados' => $oitoRecursosMaisAcessados, 
								'recursosMaisRecentes' => $oitoRecursosMaisRecentes
				    ]);
	}

	/** 
	 * Efetua a busca por TAG e então exibe a tela com o resultado da busca
	 *	@param $tag que servirá como parâmetro de busca
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaRecursoTAPorTag(Request $request){
		$tagsCadastradas = Tag::all(['nome'])->pluck('nome');

		$tag = $request->input('parametros');

		if($tag!=null){
			$recursosTA = Tag::firstWhere('nome',$tag)->recursosTA()->paginate(8);
		}else{
			$recursosTA = RecursoTA::paginate(8);
		}
		
		return view('buscaRecursoTA',[ 'tagsCadastradas' => $tagsCadastradas, 'buscaPorTag' => true, 'parametro' => $tag, 'recursosTA' => $recursosTA]);
	}

	/** 
	 * Efetua a busca por termo e então exibe a tela com o resultado da busca
	 *	@param $termo que servirá como parâmetro de busca
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaRecursoTAPorTermo(Request $request){
		$tagsCadastradas = Tag::all(['nome'])->pluck('nome');

		$termo = $request->input('parametros');

		if($termo!=null){
			$recursosTA =  RecursoTA::where('recursos_ta.titulo', 'LIKE', "%$termo%")
                  ->orWhere('recursos_ta.descricao', 'LIKE', "%$termo%")
                  ->paginate(8);
		}else{
			$recursosTA = RecursoTA::paginate(8);
		}

		return view('buscaRecursoTA',[ 'tagsCadastradas' => $tagsCadastradas, 'buscaPorTag' => false,'parametro' => $termo, 'recursosTA' => $recursosTA]);
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
	 * Exibe a tela de cadastro de usuário
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function cadastroUsuario(){
		return view('auth.register');
	}

	/** 
	 * Exibe a tela do painel do usuário
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function painelUsuario(){
		return view('painelUsuario');
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
		$recursoTA = RecursoTA::find($idRecursoTA);
		RecursoTA::where('id', $idRecursoTA)->increment('visualizacoes', 1);

		//Busca por todos os recursos TAs que possuem as mesmas tags que o recurso a ser exibido
		$recursosRelacionados = new Collection();
		foreach ($recursoTA->tags as $tag) {
			$recursosRelacionados = $recursosRelacionados->merge($tag->recursosTA);
		}
		//Ordena os recursos obtidos pela quantidade de visualizações
		$conjuntoOrdenado = $recursosRelacionados->sortBy('attributes.visualizacoes');
		//Pega os primeiros 4 para exibir como recursos relacionados
		$quatroRelacionadosMaisVistos = collect($conjuntoOrdenado)->take(4);

		$mediaAvaliacao = 0;
		$mediaAvaliacao = round($recursoTA->userAverageRating,0);
		$complementoAvaliacao = 5 - $mediaAvaliacao;

		//Utiliza o package Embed para obter a url que permita esse tipo de uso
		$embed = new Embed();
		$infoTodosVideos = Array();
		foreach ($recursoTA->videos as $video) {
			$infoVideo = $embed->get($video->url);
			array_push($infoTodosVideos,$infoVideo);
		}

		return view('exibeRecursoTA',
					['recursoTA' => $recursoTA, 
					'mediaAvaliacao' => $mediaAvaliacao,
					'complementoAvaliacao' => $complementoAvaliacao, 
					'recursosTA' =>$quatroRelacionadosMaisVistos,
					'informacoesVideos' => $infoTodosVideos]);
	}		
}
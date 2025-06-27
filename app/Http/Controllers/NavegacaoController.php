<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
		$recursosMaisAcessados = RecursoTA::where('publicacao_autorizada',true)->orderBy('visualizacoes', 'desc')->get();
		$cincoRecursosMaisAcessados = collect($recursosMaisAcessados)->take(5);

		$recursosMaisRecentes =  RecursoTA::where('publicacao_autorizada',true)->orderBy('created_at', 'desc')->get();
		$cincoRecursosMaisRecentes = collect($recursosMaisRecentes)->take(5);

		$tags = Tag::where('publicacao_autorizada', true)->get()->pluck('nome');

		return view('inicio',['listagemDeMaisRelevantes' => false, 
								'recursosMaisAcessados' => $cincoRecursosMaisAcessados, 
								'recursosMaisRecentes' => $cincoRecursosMaisRecentes,
								'tags' => $tags
				    ]);
	}

	
	private function sanitizarDados($texto, $removerPreposicao = false) {
		$temp = preg_replace('/(\s+)/', ' ', strtolower(trim(str_replace(['?', '%', '_'], ['\?', '\%', '\_'], $texto))));
		if ($removerPreposicao) {
			$temp = preg_replace('/((\s+)((a|o|e|de|do|da|de|das|por|para|com|ou|como|um|uns)(\s+))*)/', ' ', $temp);
		}
		return $temp;
	}
	public function buscarPorTexto(Request $request) {
		$texto = request('texto');
		$filtros = request('filtros');
		
		if ($texto === null && $filtros === null) return Redirect::back();
		
		$RANK_TAG_POINTS = 70;
		$RANK_TITULO_POINTS = 25;
		$RANK_DESCRICAO_POINTS = 5;

		$tags = Tag::where('publicacao_autorizada', true)->get()->pluck('nome');

		$termos = explode(' ', $this->sanitizarDados($texto, true));

		$idsTagsPublicadas = Tag::where('publicacao_autorizada', true)
							->where(function ($query) use ($termos, $filtros) {
								if ($filtros == NULL) { // Tags que contenham alguns dos termos da pesquisa
									$this->apppendOrWhere($query, 'nome', $termos);
								} else { // Tags com os nomes iguais aos filtros da pesquisa
									$saniFiltros = array_map(array($this, 'sanitizarDados'), $filtros);
									//$this->apppendOrWhere($query, 'nome', $saniFiltros);
									foreach ($saniFiltros as $f) {
										$query->orWhereRaw('LOWER(nome) = ?', $f);
									}
								}
							})
							->select('id');
							// ->get()
							// ->map(function ($item) { return $item->id;})
							// ->toArray();

		$idsRecursosPorTags = DB::table('recurso_ta_tag')
							->whereIn('tag_id', $idsTagsPublicadas)
							->select('recurso_ta_id');
		if ($filtros != NULL) { // Somente recursos com todas as tags definidas no filtro
			$idsRecursosPorTags = $idsRecursosPorTags->groupBy('recurso_ta_id')
									->havingRaw('COUNT(DISTINCT tag_id) >= ?', [count($filtros)]);
		}
		$idsRecursosPorTags = $idsRecursosPorTags->get()
							->map(function ($item) { return $item->recurso_ta_id;})
							->toArray();

		$idsRecursosPorTagsString = (count($idsRecursosPorTags) > 0) ? ('(' . implode(',', $idsRecursosPorTags) . ')') : '(0)';
		$recursosPublicados = RecursoTA::where('publicacao_autorizada', true)
								->where(function ($query) use ($termos, $idsRecursosPorTags, $filtros) {
									$query->whereIn('id', $idsRecursosPorTags);
									if ($filtros == NULL) { // WHERE IN () OR ...
										$this->apppendOrWhere($query, 'titulo', $termos);
										$this->apppendOrWhere($query, 'descricao', $termos);
									} else { // WHERE IN () AND ...
										$query->where(function ($query2) use ($termos) {
											$this->apppendOrWhere($query2, 'titulo', $termos);
											$this->apppendOrWhere($query2, 'descricao', $termos);
										});
									}
								})
								->select(['*', 
										  DB::raw("(CASE WHEN id IN $idsRecursosPorTagsString THEN $RANK_TAG_POINTS ELSE 0 END) AS rank_tag"),
										  DB::raw($this->createTextCase('titulo', $termos, $RANK_TITULO_POINTS, 'rank_titulo')),
										  DB::raw($this->createTextCase('descricao', $termos, $RANK_DESCRICAO_POINTS, 'rank_descricao'))
										 ])
								->orderByRaw('(rank_tag + rank_titulo + rank_descricao) DESC');
								

		return view('buscaRecursoTA',['tags' => $tags,'parametro' => $texto, 'filtros' => $filtros, 'recursosTA' => $recursosPublicados->get()]);
	}

	private function createWhereOptionsArray($likeLeftOperand, $likeRightOperands) {
		$result = [];
		for ($i = 0; $i < count($likeRightOperands); $i++) {
			$result[] = ['LOWER(' . $likeLeftOperand . ')', 'like', '%' . $likeRightOperands[$i] . '%'];
		}
		return $result;
	}

	private function apppendOrWhere($query, $columnName,  $terms) {
		$options = $this->createWhereOptionsArray($columnName, $terms);
		foreach ($options as $option) {
			//$query->orWhere($option[0], $option[1], $option[2]);
			$query->orWhereRaw("{$option[0]} {$option[1]} ?", [$option[2]]);
		}
	}

	private function createTextWhen($field, $text, $value) {
		$when = "WHEN {?} LIKE {?} THEN {?}";
		$quotedText = DB::getReadPDO()->quote($text);
		$quotedText = "CONCAT('%', $quotedText, '%')";
		return preg_replace(['/\{\?\}/','/\{\?\}/','/\{\?\}/'], [$field, $quotedText, $value], $when, 1);
	}

	private function createTextCase($field, array $texts, $value, $knowAs, $default = '0') {
		$case = "(CASE {?} ELSE {?} END) AS {?}";
		$whenBlock = [];
		foreach ($texts as $text) {
			$whenBlock[] = $this->createTextWhen($field, $text, $value);
		}
		$whenBlockString = implode(' ', $whenBlock);
		return preg_replace(['/\{\?\}/','/\{\?\}/','/\{\?\}/'], [$whenBlockString, $default, $knowAs], $case, 1);
	}

	/** 
	 * Efetua a busca por TAG e então exibe a tela com o resultado da busca
	 *	@param $tag que servirá como parâmetro de busca
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaRecursoTAPorTag(Request $request, $tag = null){
		if ($tag === null) return Redirect::back();
		
		$tags = Tag::where('publicacao_autorizada', true)->get()->pluck('nome');

		$arrayTagsInformadas = explode(",",$tag);

		//Busca por todos os recursos TAs que possuem as mesmas tags que o recurso a ser exibido
		$resultadoBusca = new Collection();
		foreach ($arrayTagsInformadas as $tagInformada) {
			$auxTag = Tag::firstWhere('nome',$tagInformada);
			if ($auxTag && $auxTag->publicacao_autorizada){
				$resultadoBusca = $resultadoBusca->merge($auxTag->recursosTAAprovados());
			}
		}

		//Remove duplicatas originadas por TAs em mais de uma tag
		$conjuntoOrdenado = $resultadoBusca->unique('id')->sortBy('attributes.visualizacoes');

		return view('buscaRecursoTA',['tags' => $tags, 'parametro' => '', 'filtros' => [$tag], 'recursosTA' => $conjuntoOrdenado]);
	}


	/** 
	 * Efetua a busca por todos os recursos TA
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function buscaPorTodosRecursosTA(Request $request){
		$recursosTA = RecursoTA::where('publicacao_autorizada',true)->get();
		$tags = Tag::where('publicacao_autorizada', true)->get()->pluck('nome');
		return view('buscaRecursoTA',['tags' => $tags, 'parametro' => 'Todos os recursos', 'recursosTA' => $recursosTA]);		
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

	// Exibe recurso de TA pelo slug
	public function exibeRecursoTA_slug($slug) {
		$recursoTA = RecursoTA::where('slug', $slug)->first();
		return $this->exibeRecursoTA($recursoTA);
	}
		
	public function exibeRecursoTA_id($idRecursoTA){
		$recursoTA = RecursoTA::findOrFail($idRecursoTA);
		return $this->exibeRecursoTA($recursoTA);
	}

	/** 
	 * Exibe um Recurso de Tecnologia Assistiva em específico
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */
	public function exibeRecursoTA(RecursoTA $recursoTA) {
		if (!$recursoTA->publicacao_autorizada) abort(404);
		
		RecursoTA::where('id', $recursoTA->id)->increment('visualizacoes', 1);

		//Busca por todos os recursos TAs que possuem as mesmas tags (já autorizadas)que o recurso a ser exibido
		$recursosRelacionados = new Collection();
		foreach ($recursoTA->tagsAprovadas() as $tag) {
			$recursosRelacionados = $recursosRelacionados->merge($tag->recursosTAAprovados());
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

	/** 
	 * Encaminha o usuário para a página "Acessibilidade"
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function exibePaginaAcessibilidade() {
		return view('acessibilidade');
	}

	/** 
	 * Encaminha o usuário para a página "Mapa do Site"
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function exibePaginaMapaDoSite() {
		return view('mapaDoSite');
	}
}
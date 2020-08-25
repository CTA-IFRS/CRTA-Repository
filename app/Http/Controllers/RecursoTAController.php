<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecursoTA;
use App\Tag;
use App\Video;
use App\Arquivo;

class RecursoTAController extends Controller
{
    public function store(Request $request) {

      //Expressão regular para validar a url dos videos
      $urlRegex = "";

    	//Valida os campos submetidos no formulario
    	$this->validate($request, [
        	'titulo' => 'required|max:255',
        	'descricao' => 'required|max:1020',
        	'siteFabricante' => 'required|max:2048',
        	'produtoComercial' => 'required',
        	'licenca' => 'required_if:produtoComercial,true|max:255',
          'tags[].*' => 'required|min:1',
          'videos[].*' => ['regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
          'arquivos[].*' => 'mimes:doc,docx,pdf,xls,xlsx,txt',
    	], [
      		'titulo.required' => 'É preciso informar um título para a Tecnologia Assistiva',
      		'titulo.max' => 'O título deve ter menos de 256 caracteres',
      		'descricao.required'  => 'Descreva brevemente o que está cadastrando',
      		'siteFabricante.required' => 'Informe um site do fabricante ou instituição',
      		'produtoComercial.required' => 'Marque se é um produto comercial ou não',
      		'licenca.max' => 'Informe a licença em usando menos de 256 caracteres',
          'licenca.required_if' => 'Informe a licença de distribuição desse recurso',
          'tags[].required' => 'Marque ao menos uma categoria para o recurso',
          'videos[].regex' => 'Endereço inválido, fora dos padrões',
          'arquivos' => 'Formato inválido'
    	]);
      
      //Caso esteja tudo ok, prepara para criar no DB
      $isProdutoComercial = (int)filter_var(request('produtoComercial'), FILTER_VALIDATE_BOOLEAN);

      $recursoTA = new RecursoTA();
      $recursoTA->titulo = request('titulo');
      $recursoTA->descricao = request('descricao');

      $recursoTA->produto_comercial = $isProdutoComercial;
      if($isProdutoComercial){
        $recursoTA->licenca = request('licenca');
      }else{
        $recursoTA->licenca = null;
      }

      $recursoTA->site_fabricante = request('siteFabricante');
      $recursoTA->publicacao_autorizada = false;
      $recursoTA->save();

      $recursoTA->tags()->attach(Tag::find(request('tags')));

      if(!empty(request('videos'))){             
              $videoUrls = array();
              foreach (request('videos') as $video) {
                $novoVideo = new Video();
                $novoVideo->url = $video['url'];
                $novoVideo->destaque = (int)filter_var($video['destaque'], FILTER_VALIDATE_BOOLEAN);
                array_push($videoUrls,$novoVideo);           
              }
          $recursoTA->videos()->saveMany($videoUrls);
      }

      if(!empty(request('arquivos'))){
        $arquivos = array();
        $novoArquivo = new Arquivo();
        foreach (request('arquivos') as $arquivo) {
          $novoArquivo->nome = $arquivo->getClientOriginalName();
          $novoArquivo->descricao = "";
          $novoArquivo->formato = $arquivo->getClientOriginalExtension();
          $novoArquivo->tamanho = $arquivo->getSize();
        }
      }

   		return redirect('recursosTA');
    }

    /* Antes de exibir a view, popula o form com as tags cadastradas
     *
     *  @return \Illuminate\Http\Response
     */
    public function create(){

      $tags = Tag::all(['id','nome','descricao']);
      return view('cadastrarTA',compact('tags'));
    }
}

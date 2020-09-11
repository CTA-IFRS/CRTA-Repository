<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RecursoTA;
use App\Tag;
use App\Video;
use App\Arquivo;
use App\Manual;
use App\Foto;

class RecursoTAController extends Controller
{
  public function store(Request $request) {
    	//Valida os campos submetidos no formulario

    $regras = [
     'titulo' => 'required|max:255',
     'descricao' => 'required|max:1020',
     'siteFabricante' => 'required|max:2048',
     'produtoComercial' => 'required',
     'licenca' => 'required_if:produtoComercial,true|max:255',
     'tags' => 'required',
     'videos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
     'arquivos.*.*' => 'sometimes | required',
     'arquivos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
     'manuais.*.*' => 'sometimes | required',
     'manuais.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
   ];

   $mensagens = [
    'titulo.required' => 'É preciso informar um título para a Tecnologia Assistiva',
    'titulo.max' => 'O título deve ter menos de 256 caracteres',
    'descricao.required'  => 'Descreva brevemente o que está cadastrando',
    'siteFabricante.required' => 'Informe um site do fabricante ou instituição',
    'produtoComercial.required' => 'Marque se é um produto comercial ou não',
    'licenca.max' => 'Informe a licença em usando menos de 256 caracteres',
    'licenca.required_if' => 'Informe a licença de distribuição desse recurso',
    'tags.required' => 'Informe ao menos uma tag',
    'videos[].regex' => 'Endereço inválido, fora dos padrões',
    'arquivos.*.nome.required' => 'Informe o nome do arquivo',
    'arquivos.*.formato.required' => 'Informe o formato do arquivo',
    'arquivos.*.tamanho.required' => 'Informe o tamanho do arquivo (em Megabytes)',
    'arquivos.*.url.required' => 'Informe o endereço de acesso ao arquivo',
    'arquivos.*.url.regex' => 'O endereço de acesso ao arquivo é inválido',
    'manuais.*.nome.required' => 'Informe o nome do manual',
    'manuais.*.formato.required' => 'Informe o formato do manual',
    'manuais.*.tamanho.required' => 'Informe o tamanho do manual (em Megabytes)',
    'manuais.*.url.required' => 'Informe o endereço de acesso ao manual',
    'manuais.*.url.regex' => 'O endereço de acesso ao arquivo é inválido',
  ];

    $validador = Validator::make($request->all(),$regras,$mensagens);

    //Retorna mensagens de validação no formato JSON caso haja problemas
    if($validador->fails()){
      return response()->json($validador->messages(), 422);
    }
    
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

    /**Processamento de Tags para inserção no DB**/
    /** Transforma a string com as tags recebidas em array**/
    $arrayTagsInformadas = explode(",",request('tags'));

    $arrayIdsTags = array();
    //Pesquisa no DB se a tag existe ou não, para montar o array de IDs necessários para a relação *:*
    foreach($arrayTagsInformadas as $tagInformada){
      if(Tag::where('nome', $tagInformada)->exists()){
         array_push($arrayIdsTags,Tag::where('nome',$tagInformada)->get()->pluck('id')->get(0));
      }else{
         $novaTag = new Tag();
         $novaTag->nome = $tagInformada;
         $novaTag->publicacao_autorizada = false;
         $novaTag->save();
         array_push($arrayIdsTags,$novaTag->id);
      }
    }
    $recursoTA->tags()->attach($arrayIdsTags);

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

    if(!empty(request('fotos'))){

      $fotos = array();
      foreach (request('fotos') as $foto) {
        //Torna o nome aleatorio para evitar colisão, evitar possibilidade de bugs futuros
        $novoNomeFoto = time().'_'.$foto->getClientOriginalName();
        //Salva a foto no servidor, na pasta uploads
        $caminhoFoto = $foto->storeAs('uploads',$novoNomeFoto,'public');
        $novaFoto = new Foto();
        $novaFoto->caminho_arquivo= $caminhoFoto;
        if($foto->getClientOriginalName()==request('fotoDestaque')){
          $novaFoto->destaque = true;
        }else{
          $novaFoto->destaque = false;
        }
        $novaFoto->texto_alternativo = request(str_replace('.','_',str_replace(' ','_',$foto->getClientOriginalName())));
        array_push($fotos,$novaFoto);
      }
      $recursoTA->fotos()->saveMany($fotos);
    }

    if(!empty(request('arquivos'))){
      $arquivoUrls = array();
      foreach (request('arquivos') as $arquivo) {
        $novoArquivo = new Arquivo();
        $novoArquivo->url = $arquivo['url'];
        $novoArquivo->nome = $arquivo['nome'];
        $novoArquivo->formato = $arquivo['formato'];
        $novoArquivo->tamanho = (float)filter_var($arquivo['tamanho'], FILTER_VALIDATE_FLOAT);
        array_push($arquivoUrls,$novoArquivo);
      }
      $recursoTA->arquivos()->saveMany($arquivoUrls);
    }

    if(!empty(request('manuais'))){
      $manualUrls = array();
      foreach (request('manuais') as $manual) {
        $novoManual = new Manual();
        $novoManual->url = $manual['url'];
        $novoManual->nome = $manual['nome'];
        $novoManual->formato = $manual['formato'];
        $novoManual->tamanho = (float) $manual['tamanho'];
        array_push($manualUrls,$novoManual);
      }
      $recursoTA->manuais()->saveMany($manualUrls);
    }

    /*TODO: Alterar os modelos e migrations para os novos valores**/

    return redirect('recursosTA');
  }

    /* Antes de exibir a view, popula o form com as tags cadastradas
     *
     *  @return \Illuminate\Http\Response
     */
    public function create(){

      $tags = Tag::all(['nome'])->pluck('nome');
      return view('cadastrarTA')->with("tags",$tags);
    }

    /* Lista todos os Recursos de Tecnologia Assistiva e seus dados associados
    *
    *   @return \Illuminate\Http\Response
    */

    public function retrieveAll(){
      $recursosTA = RecursoTA::all();
      return view('listaRecursosTA',['recursosTA' => $recursosTA]);
    }


    /* Lista e pagina os recursos ta
    *
    *   @return \Illuminate\Http\Response
    */

    public function listaComPaginacao(){
      $recursosTA = RecursoTA::paginate(15);
      return view('testeCards',['recursosTA' => $recursosTA]);
    }
  }

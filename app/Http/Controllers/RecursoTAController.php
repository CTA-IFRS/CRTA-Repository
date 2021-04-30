<?php

namespace App\Http\Controllers;

// include composer autoload
require '../vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Image;
use App\RecursoTA;
use App\Tag;
use App\Video;
use App\Arquivo;
use App\Manual;
use App\Foto;
use Cookie;

class RecursoTAController extends Controller{
  public function store(Request $request) {

    $regras = [
     'titulo' => 'required|max:255',
     'descricao' => 'required',
     'siteFabricante' => 'required',
     'produtoComercial' => 'required',
     'licenca' => 'required_if:produtoComercial,true|max:255',
     'tags' => 'required',
     'videos.*.url' => ['sometimes','url'],
     'arquivos.*.*' => 'sometimes | required',
     'arquivos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
     'manuais.*.*' => 'sometimes | required',
     'manuais.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
     'textosAlternativos.*.textoAlternativo' => 'required',
     'fotos.*' => 'required|mimetypes:image/jpeg,image/png|dimensions:min_width=200,min_height=150,max_width=800,max_height=600|max:2048',
     'fotoDestaque' => 'required',
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
    'textosAlternativos.*.textoAlternativo.required' => 'Informe o texto alternativo para a imagem',
    'textosAlternativos.*.textoAlternativo.max' => 'O texto alternativo deve ter menos de 255 caracteres',
    'fotos.required' => 'Faça o upload de ao menos uma foto do recurso',
    'fotos.*.mimetypes' => 'A foto deve ser ou jpeg, ou jpg, ou png.',
    'fotos.*.dimensions' => 'As fotos devem estar dimensionadas com a largura entre 200 e 800 pixels e a altura entre 150 e 600 pixels',
    'fotos.*.max' => 'O tamanho das fotos deve ser de no máximo 2MB',
    'fotoDestaque.required' =>  'Escolha uma foto para ser exibida primeiro ao listar a tecnologia assistiva',
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
      array_push($videoUrls,$novoVideo);           
    }
    $recursoTA->videos()->saveMany($videoUrls);
  }

  if($request->hasFile('fotos')){
    $textosAlternativos = array();
    $textosAlternativos = request('textosAlternativos');
    $fotosCarregadas = $request->file('fotos');
    $fotos = array();
    
    foreach ($fotosCarregadas as $key => $foto) {
      //Torna o nome aleatorio para evitar colisão, evitar possibilidade de bugs futuros
      $novoNomeFoto = time().'_'.$foto->getClientOriginalName();

      // Gera uma imagem com fundo transparente
      // Se for necessário uma cor no background, informe no terceiro parâmetro (e.g: '#000000')
      $fotoRedimensionada = Image::canvas(640, 480);
      
      $fotoEmProcessamento  = Image::make($foto)->resize(640, 480, function($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg');
      
      $fotoRedimensionada->insert($fotoEmProcessamento, 'center');
      $fotoEmProcessamento->destroy();

      if (!Storage::disk('public')->has('uploads')) {
        Storage::disk('public')->makeDirectory('uploads', 0775, true, true);
      }
      $fotoRedimensionada->save(storage_path('app/public/uploads/').$novoNomeFoto);
      $fotoRedimensionada->destroy();

      //Processa a imagem para criar a thumbnail
      $thumbnailFoto = Image::make($foto);

      $larguraMaximaThumbail = 200; //px_close(pxdoc)
      $alturaMaximaThumbnail = 150; //px

      $thumbnailFoto->resize($larguraMaximaThumbail, $alturaMaximaThumbnail, function ($constraint) {
        $constraint->aspectRatio();
      });
      
      if (!Storage::disk('public')->has('thumbnails')) {
        Storage::disk('public')->makeDirectory('thumbnails', 0775, true, true);
      } 
      //Salva a thumbnail criada a partir da imagem do upload
      $thumbnailFoto->save(storage_path('app/public/thumbnails/').$novoNomeFoto,100);
      $thumbnailFoto->destroy();

      //Instancia uma Foto para adicionar ao array de fotos do RecursoTA
      $novaFoto = new Foto();
      $novaFoto->caminho_arquivo= 'uploads/'.$novoNomeFoto;
      $novaFoto->caminho_thumbnail= 'thumbnails/'.$novoNomeFoto;

      $novaFoto->texto_alternativo = $textosAlternativos['nova-'.$key]['textoAlternativo'];
      if(preg_match("/nova-".$key."/",request('fotoDestaque'))){
        $novaFoto->destaque = true;
      }else{
        $novaFoto->destaque = false;
      }

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

  return response()->json("Recurso cadastrado com sucesso!");
}

  /* Antes de exibir a view, popula o form com as tags cadastradas
   *
   *  @return \Illuminate\Http\Response
   */
  public function create(){
    $tags = Tag::where('publicacao_autorizada', true)->pluck('nome');
    return view('cadastrarTA')->with("tags",$tags);
  }


  /* Lista e pagina os recursos ta
  *
  *   @return \Illuminate\Http\Response
  */

  public function listaComPaginacao(){
    $recursosTA = RecursoTA::paginate(15);
    return view('layouts.listaCardsRecursos',['recursosTA' => $recursosTA]);
  }


 /* Repassa o HTML do blade que lista os RecursosTA para que seja aplicado como conteúdo da div 
  * e atualize, assincronamente, os recursos na tela.
  *
  *   @return \Illuminate\Http\Response
  */
 public function atualizaListaAssincronamente(Request $request){
  if($request->ajax()){
    $recursosTA = RecursoTA::paginate(8);
    return view('layouts.listaCardsRecursos',['recursosTA' => $recursosTA])->render();
  }
}


  /* Atribui a nota dada pelo usuário ao RecursoTA
   *
   */
  public function avaliarRecursoTA(Request $request){

    $rating = new \willvincent\Rateable\Rating;

    $rating->rating = $request->nota;
    $rating->user_id = null;

    //Verifica se o usuário já avaliou o recurso pelo cooki
    if($request->hasCookie("avaliouRecursoTA_".$request->idRecurso)===false){
      $recursoTA = RecursoTA::findOrFail($request->idRecurso);
      $recursoTA->ratings()->save($rating);

      $novaMediaAvaliacao = 0;
      $novaMediaAvaliacao = $recursoTA->userAverageRating;

      return response()->json(["Agradecemos por avaliar esse recurso!",$novaMediaAvaliacao],202)->withCookie($cookie = cookie("avaliouRecursoTA_".$request->idRecurso, true));        
    }    
     
    return response()->json(["Você já avaliou esse recurso antes, nota não registrada"]);
    
  }
}
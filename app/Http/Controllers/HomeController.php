<?php

namespace App\Http\Controllers;

// include composer autoload
require '../vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Image;
use App\RecursoTA;
use App\Tag;
use App\Video;
use App\Arquivo;
use App\Manual;
use App\Foto;
use App\Pagina;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recursosNaoAprovados = RecursoTA::where('publicacao_autorizada','false')->count();
        $tagsNaoAprovadas = Tag::where('publicacao_autorizada','false')->count();
        return view('painelAdministrador',[ 'qtdRecursosNaoAprovados' => $recursosNaoAprovados,
            'qtdTagsNaoAprovadas' => $tagsNaoAprovadas]);
    }

    /**
     * Encaminha para a página onde todos os dados do usuário logado poderão ser editados
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function informacoesUsuario()
    {
        $usuario = auth()->user();
        return view('informacoesUsuario', ['usuario' => $usuario]);
    }

    /**
     * Salva alterações realizadas e encaminha novamente para a página de edição
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function salvaInformacoesUsuario(Request $request)
    {
        $usuario = auth()->user();
        return view('informacoesUsuario', ['usuario' => $usuario]);
    }

    /**
     * Encaminha para a página onde todos os recursos cadastrados, aprovados ou não,
     * serão listados.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function administrarRecursosTA()
    {
        $recursosTA = RecursoTA::all();
        return view('administrarRecursosTA', ['recursosTA' => $recursosTA]);
    } 

    /**
     * Encaminha para a página onde todos as tags cadastradas, aprovadas ou não,
     * serão listadas.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function administrarTags()
    {
        $tags = Tag::all();
        return view('administrarTags', ['tags' => $tags]);
    }

    /**
     * Torna disponível para futuros cadastros a tag com o id passado por parâmetro
     * Após, encaminha para a página onde todos as tags cadastradas, aprovadas ou não,
     * serão listadas.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function autorizaPublicacaoTag($idTag)
    {
        $tagAlvo = Tag::findOrFail($idTag);
        $tagAlvo->publicacao_autorizada = true;
        $tagAlvo->save();

        $tags = Tag::all();
        return view('administrarTags', ['tags' => $tags]);
    }

    /**
     * Torna indisponível para futuros cadastros a tag com o id passado por parâmetro
     * Após, encaminha para a página onde todos as tags cadastradas, aprovadas ou não,
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function omitirPublicacaoTag($idTag)
    {
        $tagAlvo = Tag::findOrFail($idTag);
        $tagAlvo->publicacao_autorizada = false;
        $tagAlvo->save();

        $tags = Tag::all();
        return view('administrarTags', ['tags' => $tags]);
    }

    /**
     * Exibe o form para edição da tag passada por parâmetro
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editarTag($idTag)
    {
        $tagAlvo = Tag::findOrFail($idTag);

        return view('editarTag', ['tag' => $tagAlvo]);
    }

    /**
     * Processa o form de edição de tag e persiste a alteração
     * no banco de dados.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function salvaEdicaoTag(Request $request)
    {
        $regras = [
         'nomeTag' => 'required|max:255',
     ];

     $mensagens = [
        'nomeTag.required' => 'É preciso informar um nome para a Tag',
        'nomeTag.max' => 'A Tag deve ter menos de 256 caracteres',
    ];

    $validador = Validator::make($request->all(),$regras,$mensagens);

      //Retorna mensagens de validação no formato JSON caso haja problemas
    if($validador->fails()){
        return response()->json($validador->messages(), 422);
    }

    $tagAlvo = Tag::findOrFail($request->idTag);
    $tagAlvo->nome = $request->nomeTag;
    $tagAlvo->publicacao_autorizada = $tagAlvo->publicacao_autorizada; 
    $tagAlvo->save();

    $tags = Tag::all();
    return view('administrarTags', ['tags' => $tags]);
}

    /**
     * Exibe os dados do recurso a ser avaliado
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function revisarRecursoTA($idRecursoTA)
    {
        //Necessário para coordenar os arrays que compõem os inputs de manuais, arquivos e vídeos
        $contadorUrls = 0;

        $recursoAlvo = RecursoTA::findOrFail($idRecursoTA);

        $tagsDoSistema = Tag::all(['nome'])->pluck('nome');
        $tagsDoRecursoTA = implode(',',$recursoAlvo->tags->pluck('nome')->toArray());

        return view('revisarRecursoTA', ['recursoTA' => $recursoAlvo,
           'tagsDoSistema' => $tagsDoSistema,
           'tagsDoRecursoTA' => $tagsDoRecursoTA,
           'contadorUrls' => $contadorUrls]);
    }

    /**
     * Exibe o formulário para o administrador cadastrar um recurso TA
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adicionarRecursoTA()
    {
        //Necessário para coordenar os arrays que compõem os inputs de manuais, arquivos e vídeos
        $contadorUrls = 0;

        $tagsDoSistema = Tag::all(['nome'])->pluck('nome');

        return view('adicionarRecursoTA',['tagsDoSistema' =>$tagsDoSistema]);
    }  

    /**
     * Autoriza a publicação do recurso no RETACE
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function autorizarPublicacaoRecursoTA($idRecursoTA)
    {
        $recursoAlvo = RecursoTA::findOrFail($idRecursoTA);
        $recursoAlvo->publicacao_autorizada = true;
        $recursoAlvo->save();

        return redirect('/administrarRecursosTA');
    }

    /**
     * Oculta o recurso TA para que não seja listado pelo sistema
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function omitirRecursoTA($idRecursoTA)
    {
        $recursoAlvo = RecursoTA::findOrFail($idRecursoTA);
        $recursoAlvo->publicacao_autorizada = false;
        $recursoAlvo->save();

        return redirect('/administrarRecursosTA');
    }

    /**
     * Remove a foto do servidor
     *
     */
    public function removeFoto($idFoto)
    {
        $feedbackExclusão = true;

        $foto = Foto::findOrFail($idFoto);
        //Deleta os arquivos das fotos armazenados no servidor
        $caminhoCompletoFoto = storage_path('app/public/').$foto->caminho_arquivo;
        $caminhoCompletoThumbnail = storage_path('app/public/').$foto->caminho_thumbnail;

        if(File::exists($caminhoCompletoThumbnail)) {
            if(File::delete($caminhoCompletoThumbnail)){
                $feedbackExclusão = $feedbackExclusão && true;
            }else{
                $feedbackExclusão = $feedbackExclusão && false;
            }
        }

        if(File::exists($caminhoCompletoFoto)) {
            if(File::delete($caminhoCompletoFoto)){
                $feedbackExclusão = $feedbackExclusão && true;
            }else{
                $feedbackExclusão = $feedbackExclusão && false;
            }
        }

        Foto::destroy($idFoto);

        return response()->json("Foto removida com sucesso",200);    
    }


    /**
     * Excluir o recurso TA do banco de dados
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editarRecursoTA(Request $request, $idRecursoTA)
    {   
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
         'fotos.*.*' => 'required|mimes:jpg,png',
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
        'fotos.mimes' => 'A foto deve ser ou jpeg, ou jpg, ou png.',
        'fotoDestaque.required' =>  'Escolha uma foto para ser exibida primeiro ao listar a tecnologia assistiva',
    ];

    $validador = Validator::make($request->all(),$regras,$mensagens);

    //Retorna mensagens de validação no formato JSON caso haja problemas
    if($validador->fails()){
        return response()->json($validador->messages(), 422);
    }

    //Caso esteja tudo ok, prepara para criar no DB
    $isProdutoComercial = (int)filter_var(request('produtoComercial'), FILTER_VALIDATE_BOOLEAN);

    $recursoTA = RecursoTA::findOrFail($idRecursoTA);

    $recursoTA->titulo = request('titulo');
    $recursoTA->descricao = request('descricao');

    $recursoTA->produto_comercial = $isProdutoComercial;
    if($isProdutoComercial){
        $recursoTA->licenca = request('licenca');
    }else{
        $recursoTA->licenca = null;
    }

    $recursoTA->site_fabricante = request('siteFabricante');
    //Por estar autenticado como admin, cadastra já com a autorização
    $recursoTA->publicacao_autorizada = true;
    $recursoTA->save();

    //Apaga os relacionamentos do RecurstoTA com as tags existentes, para simplificar a lógica de update
    DB::table('recurso_ta_tag')->where('recurso_ta_id','=',$idRecursoTA)->delete();

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
            //Por estar autenticado como admin, cadastra já com a autorização
            $novaTag->publicacao_autorizada = true;
            $novaTag->save();
            array_push($arrayIdsTags,$novaTag->id);
        }
    }
    $recursoTA->tags()->attach($arrayIdsTags);

    /*Para simplificar a lógica do update, destrói os videos relacionados atualmente*/

    $videosRecursoTA = $recursoTA->videos;
    $idsVideos = Array();
    foreach ($videosRecursoTA as $video) {
        array_push($idsVideos, $video->id);
    }

    if(count($idsVideos)!=0){
        Video::destroy($idsVideos);
    } 

    /*Processa os vídeos recebidos pelo form*/
    if(!empty(request('videos'))){             
        $videoUrls = array();
        foreach (request('videos') as $video) {
            $novoVideo = new Video();
            $novoVideo->url = $video['url'];
            array_push($videoUrls,$novoVideo);           
        }
        $recursoTA->videos()->saveMany($videoUrls);
    }

    $textosAlternativos = array();
    $textosAlternativos = request('textosAlternativos');

    /*Itera por todas as fotos já cadastradas e salvas no servidor para estabelecer a foto destaque
     *e atualizar os textos alternativos
     */
    foreach ($recursoTA->fotos as $foto) {
        $foto->destaque=false;
        $foto->texto_alternativo=$textosAlternativos[$foto->id]['textoAlternativo'];
        $foto->save();
    }

    $caminhoArquivoFotoDestaque = null;

    /* Processa as novas fotos recebidas do Form. Fotos antigas já estão salvas e 
     * aquelas deletadas são processadas assincronamente (ao apertar o botão lixeira) antes do envio do form
     */
    if($request->hasFile('fotos')){
        $fotosCarregadas = $request->file('fotos');
        $fotos = array();
        foreach ($fotosCarregadas as $key => $foto) {
            //Torna o nome aleatorio para evitar colisão, evitar possibilidade de bugs futuros
            $novoNomeFoto = time().'_'.$foto->getClientOriginalName();

            // This will generate an image with transparent background
            // If you need to have a background you can pass a third parameter (e.g: '#000000')
            $fotoRedimensionada = Image::canvas(640, 480);

            $fotoEmProcessamento  = Image::make($foto)->resize(640, 480, function($constraint)
            {
                $constraint->aspectRatio();
            })->encode('jpg');

            $fotoRedimensionada->insert($fotoEmProcessamento, 'center');
            $fotoRedimensionada->save(storage_path('app/public/uploads/').$novoNomeFoto);

            //$caminhoFoto = $foto->storeAs('uploads',$novoNomeFoto,'public');
            //Processa a imagem para criar a thumbnail
            $thumbnailFoto = Image::make($foto);

            $larguraMaximaThumbail = 200; //px_close(pxdoc)
            $alturaMaximaThumbnail = 150; //px
            //Dependendo da dimensão que for maior, limita o resize.
            $thumbnailFoto->height() > $thumbnailFoto->width() ? $width=null : $height=null;

            $thumbnailFoto->resize($larguraMaximaThumbail, $alturaMaximaThumbnail, function ($constraint) {
                $constraint->aspectRatio();
            });

            //Salva a thumbnail criada a partir da imagem do upload
            $thumbnailFoto->save(storage_path('app/public/thumbnails/').$novoNomeFoto,100);

            //Instancia uma Foto para adicionar ao array de fotos do RecursoTA
            $novaFoto = new Foto();
            $novaFoto->caminho_arquivo= 'uploads/'.$novoNomeFoto;
            $novaFoto->caminho_thumbnail= 'thumbnails/'.$novoNomeFoto;

            $novaFoto->texto_alternativo = $textosAlternativos['nova-'.$key]['textoAlternativo'];
            if(preg_match("/nova-".$key."/",request('fotoDestaque'))){
                $novaFoto->destaque = true;
                $caminhoArquivoFotoDestaque = $novaFoto->caminho_arquivo;
            }
            array_push($fotos,$novaFoto);
        }
        $recursoTA->fotos()->saveMany($fotos);
    }

    if(!isset($caminhoArquivoFotoDestaque) && null!=request('fotoDestaque')){
        $novaFotoDestaque = Foto::findOrFail(request('fotoDestaque'));
        $novaFotoDestaque->destaque = true;
        $novaFotoDestaque->save();
    }

    /* Destrói os arquivos existentes para facilitar a lógica da exclusão
     *
     */
    $arquivosRecursoTA = $recursoTA->arquivos;
    $idsArquivos = Array();
    foreach ($arquivosRecursoTA as $arquivo) {
        array_push($idsArquivos, $arquivo->id);
    }

    if(count($idsArquivos)!=0){
        Arquivo::destroy($idsArquivos);
    }

    /* Processa os arquivos recebidos pelo form */ 
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

    /* Destrói os arquivos existentes para facilitar a lógica da exclusão
     *
     */
    $manuaisRecursoTA = $recursoTA->manuais;
    $idsManuais = Array();
    foreach ($manuaisRecursoTA as $manual) {
        array_push($idsManuais, $manual->id);
    }

    if(count($idsManuais)!=0){
        Manual::destroy($idsManuais);
    }    

    /* Processa os manuais recebidos pelo form */ 
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

    /**
     * Excluir o recurso TA do banco de dados
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function excluirRecursoTA($idRecursoTA)
    {
        $feedbackExclusão = true;

        $recursoAlvo = RecursoTA::findOrFail($idRecursoTA);

        //Prepara arrays com os IDs de videos, manuais, arquivos e fotos relacionados
        //OBS.: As tags não serão excluídas, apenas o registro na tabela *:*
        $manuaisRecursoTA = $recursoAlvo->manuais;
        $idsManuais = Array();
        foreach ($manuaisRecursoTA as $manual) {
            array_push($idsManuais, $manual->id);
        }

        if(count($idsManuais)!=0){
            Manual::destroy($idsManuais);
        } 

        $arquivosRecursoTA = $recursoAlvo->arquivos;
        $idsArquivos = Array();
        foreach ($arquivosRecursoTA as $arquivo) {
            array_push($idsArquivos, $arquivo->id);
        }

        if(count($idsArquivos)!=0){
         Arquivo::destroy($idsArquivos);
     } 

     $videosRecursoTA = $recursoAlvo->videos;
     $idsVideos = Array();
     foreach ($videosRecursoTA as $video) {
        array_push($idsVideos, $video->id);
    }

    if(count($idsVideos)!=0){
        Video::destroy($idsVideos);
    } 

    $fotosRecursoTA = $recursoAlvo->fotos;
    $idsFotos = Array();
    foreach ($fotosRecursoTA as $foto) {

        array_push($idsFotos, $foto->id);

            //Deleta os arquivos das fotos armazenados no servidor
        $caminhoCompletoFoto = storage_path('app/public/').$foto->caminho_arquivo;
        $caminhoCompletoThumbnail = storage_path('app/public/').$foto->caminho_thumbnail;

        if(File::exists($caminhoCompletoThumbnail)) {
            if(File::delete($caminhoCompletoThumbnail)){
                $feedbackExclusão = $feedbackExclusão && true;
            }else{
                $feedbackExclusão = $feedbackExclusão && false;
            }
        }

        if(File::exists($caminhoCompletoFoto)) {
            if(File::delete($caminhoCompletoFoto)){
                $feedbackExclusão = $feedbackExclusão && true;
            }else{
                $feedbackExclusão = $feedbackExclusão && false;
            }
        }
    }

    if(count($idsFotos)!=0){
        Foto::destroy($idsFotos);
    } 

    DB::table('recurso_ta_tag')->where('recurso_ta_id','=',$idRecursoTA)->delete();

    RecursoTA::destroy($idRecursoTA);

    return view('/administrarRecursosTA')->with(
        "sucessoExclusao" , "Informações excluídas do RETACE com sucesso!"
    );
}

    /**
     * Insere o RecursoTA no banco de dados, com autorizações já fornecidas
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insereRecursoTA(Request $request) {

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
         'fotos.*.*' => 'required|mimes:jpg,png',
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
        'fotos.mimes' => 'A foto deve ser ou jpeg, ou jpg, ou png.',
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
    //Por estar autenticado como admin, cadastra já com a autorização
    $recursoTA->publicacao_autorizada = true;
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
            //Por estar autenticado como admin, cadastra já com a autorização
            $novaTag->publicacao_autorizada = true;
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

            // This will generate an image with transparent background
            // If you need to have a background you can pass a third parameter (e.g: '#000000')
            $fotoRedimensionada = Image::canvas(640, 480);

            $fotoEmProcessamento  = Image::make($foto)->resize(640, 480, function($constraint)
            {
                $constraint->aspectRatio();
            })->encode('jpg');

            $fotoRedimensionada->insert($fotoEmProcessamento, 'center');
            $fotoRedimensionada->save(storage_path('app/public/uploads/').$novoNomeFoto);

            //$caminhoFoto = $foto->storeAs('uploads',$novoNomeFoto,'public');
            //Processa a imagem para criar a thumbnail
            $thumbnailFoto = Image::make($foto);

            $larguraMaximaThumbail = 200; //px_close(pxdoc)
            $alturaMaximaThumbnail = 150; //px
            //Dependendo da dimensão que for maior, limita o resize.
            $thumbnailFoto->height() > $thumbnailFoto->width() ? $width=null : $height=null;

            $thumbnailFoto->resize($larguraMaximaThumbail, $alturaMaximaThumbnail, function ($constraint) {
                $constraint->aspectRatio();
            });

            //Salva a thumbnail criada a partir da imagem do upload
            $thumbnailFoto->save(storage_path('app/public/thumbnails/').$novoNomeFoto,100);

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

    /**
     * Encaminha para o formulário de edição de conteúdo da página 'Aprender'
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editarPaginaAprender()
    {
        $conteudoPagina = Pagina::where('nome','Aprender')->firstOrFail();
        return view('editarPaginaAprender',['conteudoPagina' => $conteudoPagina]);
    }

    /**
     * Processo o formulário de edição de conteúdo da página 'Aprender'
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function salvarEdicaoPaginaAprender(Request $request)
    {
        $regras = [
         'titulo' => 'required|max:255',
         'descricao' => 'required',
     ];

     $mensagens = [
        'titulo.required' => 'É preciso informar um título para o texto da página "Alterar" ',
        'titulo.max' => 'O título deve ter menos de 256 caracteres',
        'descricao.required'  => 'A página "Alterar" deve possuir um texto ',
    ];

    $validador = Validator::make($request->all(),$regras,$mensagens);

        //Retorna mensagens de validação no formato JSON caso haja problemas
    if($validador->fails()){
        return response()->json($validador->messages(), 422);
    }

    $pagina = Pagina::where('nome', 'Aprender')->firstOrFail();

    $pagina->titulo_texto = request('titulo');
    $pagina->texto = request('descricao');

    $pagina->save();

    return response()->json("Edição publicada com sucesso!", 200);
} 



    public function emailNovoRecursoTA($idRecursoTA){

        $recursoTA = RecursoTA::findOrFail($idRecursoTA);


        $to_name = 'Guilherme';
        $to_email = 'gmottin27@gmail.com';
        $data = array('tituloRecurso'=> $recursoTA->titulo, 'idRecursoTA' => $idRecursoTA);

        Mail::send('emailNovoRecursoTA', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Teste de envio de email Laravel');
            $message->from('cta@ifrs.edu.br','Email de Teste');
        }); 

    return 'Email sent Successfully';

    }

    /**
     * Encaminha para a página onde todos os usuários cadastrados
     * serão listados.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function administrarUsuarios()
    {
        $usuarios = User::all();
        return view('administrarUsuarios', ['usuarios' => $usuarios]);
    }


    /**
     * Encaminha para a página com o formulário de cadastro do usuário
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adicionarUsuario()
    {
        return view('adicionarUsuario');
    }


    /**
     * Processa o form de cadastro de usuário
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cadastrarUsuario(Request $request)
    {
        $regras = [ 'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]; 

        $mensagens = [  'name.required' => 'É preciso informar o nome do usuário',
                        'name.max' => 'O nome deve ter até 255 caracteres',
                        'name.string' => 'O nome deve possuir apenas letras',
                        'email.required' => 'É preciso informar o e-mail do usuário',
                        'email.max' => 'O e-mail deve ter até 255 caracteres',
                        'email.string' => 'O nome deve ser uma string',
                        'email.email' => 'Formato de endereço inválido',
                        'email.unique' => 'Já existe uma conta com esse e-mail',
                    ];

         $validador = Validator::make($request->all(),$regras,$mensagens);

         //Retorna mensagens de validação no formato JSON caso haja problemas
        if($validador->fails()){
            return response()->json($validador->messages(), 422);
        }

        $novoUsuario = new User();
        $novoUsuario->name = $request->name;
        $novoUsuario->email = $request->email;
        $senhaGerada = Str::random(8);
        $novoUsuario->password = Hash::make($senhaGerada);
        $novoUsuario->save();

        $this->enviaEmailNovoUsuario($novoUsuario,$senhaGerada);

        return response()->json("Usuário cadastrado com sucesso!");
    }

    /**
    * Método acessório para notificar o usuário de que a conta foi criada
    */
    private function enviaEmailNovoUsuario(User $novoUsuario,$senhaGerada){

        $to_name = $novoUsuario->name;
        $to_email = $novoUsuario->email;
        $data = array('nomeUsuario'=> $novoUsuario->name, 'senha' => $senhaGerada);

        Mail::send('emailNovoUsuario', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Cadastro efetuado no RETACE');
            $message->from('cta@ifrs.edu.br','RETACE');
        }); 

        return 'Mensagem de cadastro enviada com sucesso';

    }

    /**
     * Encaminha para a página com o formulário de edição do usuário
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editarUsuario($idUsuario)
    {
        $usuario = User::findOrFail($idUsuario);
        return view('editarUsuario', [ 'usuario' => $usuario]);
    }


    /**
     * Processa o form de edição de usuário
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function atualizarUsuario(Request $request, $idUsuario)
    {
        $regras = [ 'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $idUsuario.',id'],
                ]; 

        $mensagens = [  'name.required' => 'É preciso informar o nome do usuário',
                        'name.max' => 'O nome deve ter até 255 caracteres',
                        'name.string' => 'O nome deve possuir apenas letras',
                        'email.required' => 'É preciso informar o e-mail do usuário',
                        'email.max' => 'O e-mail deve ter até 255 caracteres',
                        'email.string' => 'O nome deve ser uma string',
                        'email.email' => 'Formato de endereço inválido',
                        'email.unique' => 'Já existe uma conta com esse e-mail',
                    ];

         $validador = Validator::make($request->all(),$regras,$mensagens);

         //Retorna mensagens de validação no formato JSON caso haja problemas
        if($validador->fails()){
            return response()->json($validador->messages(), 422);
        }

        $usuarioEditado = User::findOrFail($idUsuario);
        $usuarioEditado->name = $request->name;

        if($usuarioEditado->email != $request->email){
            $this->enviaEmailAlteracaoConta($request->email,$usuarioEditado);
            $usuarioEditado->email = $request->email;
        }

        $usuarioEditado->save();
        
        return response()->json("Usuário editado com sucesso!");
    }

    /**
     * Método acessório para enviar mensagens aos endereços de e-mail antigo e novo para
     * notificar a alteração.
     */
    private function enviaEmailAlteracaoConta($emailNovo,User $usuarioEditado){

        $to_name = $usuarioEditado->name;
        $to_email = $usuarioEditado->email;
        $data = array('nomeUsuario'=> $usuarioEditado->name, 'emailAntigo' => $usuarioEditado->email, 'emailNovo' => $emailNovo);

        Mail::send('emailAlteracaoContaUsuario', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('E-mail de acesso ao RETACE alterado');
            $message->from('cta@ifrs.edu.br','RETACE');
        });

        Mail::send('emailAlteracaoContaUsuario', $data, function($message) use ($to_name, $emailNovo) {
            $message->to($emailNovo, $to_name)
            ->subject('E-mail de acesso ao RETACE alterado');
            $message->from('cta@ifrs.edu.br','RETACE');
        });  

        return 'Mensagem de alteração de e-mail enviada com sucesso';

    }

    public function recuperarSenha($idUsuario){

        $usuario = User::findOrFail($idUsuario);
        $senhaGerada = Str::random(8);
        $usuario->password = Hash::make($senhaGerada);
        $usuario->save();

        $this->enviaEmailRecuperacaoSenha($usuario,$senhaGerada);

        return response()->json("Recuperação e envio de senha concluídos com sucesso!");        
    }

    /**
    * Método acessório para enviar ao usuário uma nova senha de acesso.
    */
    private function enviaEmailRecuperacaoSenha(User $usuario,$senhaGerada){

        $to_name = $usuario->name;
        $to_email = $usuario->email;
        $data = array('nomeUsuario'=> $usuario->name, 'senha' => $senhaGerada);

        Mail::send('emailRecuperacaoSenhaUsuario', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Recuperação de senha de conta');
            $message->from('cta@ifrs.edu.br','RETACE');
        }); 

        return 'Mensagem com nova senha enviada com sucesso';

    }


    public function excluirUsuario(Request $request){

        $usuario = User::findOrFail($request->idUsuario);
        User::destroy($request->idUsuario);


        $this->enviaEmailExclusaoConta($usuario);

        return response()->json("Exclusão e envio de notificação concluídos com sucesso!");        
    }

    /**
    * Método acessório para enviar ao usuário a notificação de exclusão da conta.
    */
    private function enviaEmailExclusaoConta(User $usuario){

        $to_name = $usuario->name;
        $to_email = $usuario->email;
        $data = array('nomeUsuario'=> $usuario->name);

        Mail::send('emailExclusaoUsuario', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Conta do RETACE encerrada');
            $message->from('cta@ifrs.edu.br','RETACE');
        }); 

        return 'Notificação de exclusão de conta enviada com sucesso';

    }
}

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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;

use Image;
use App\RecursoTA;
use App\Tag;
use App\Video;
use App\Arquivo;
use App\Manual;
use App\Foto;
use App\Pagina;
use App\User;
use App\Upload;
use App\RecursoTaTag;

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
        $tags = Tag::orderBy('publicacao_autorizada', 'asc')->get();
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

    public function removerTag($idTag) {
        $tag = Tag::findOrFail($idTag);
        RecursoTaTag::where('tag_id', $idTag)->delete();
        $tag->delete();

        $tags = Tag::all();
        return view('administrarTags', ['tags' => $tags]);
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
         'nomeTag' => 'required|max:255|unique:App\Tag,nome',
     ];

     $mensagens = [
        'nomeTag.required' => 'É preciso informar um nome para a Tag',
        'nomeTag.max' => 'A Tag deve ter menos de 256 caracteres',
        'nomeTag.unique' => 'Este nome já foi utilizado por outra Tag'
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

    //$tags = Tag::all();
    //return view('administrarTags', ['tags' => $tags]);
    return response()->json("Tag atualizada com sucesso!");
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

        $tagsDoSistema = Tag::where('publicacao_autorizada', true)->pluck('nome');;
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

        $tagsDoSistema = Tag::where('publicacao_autorizada', true)->pluck('nome');

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
     * Editar o recurso de TA do banco de dados
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editarRecursoTA(Request $request, $idRecursoTA)
    {   
        $regras = [
         'titulo' => 'required|max:255',
         'descricao' => 'required',
         'siteFabricante' => [/*'required'*/ 'nullable', 'url'],
         'produtoComercial' => 'required',
         'licenca' => 'max:255',
         'tags' => 'required',
         'videos.*.url' => ['sometimes','url'],
         'arquivos.*.nome' => 'required',
         'arquivos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
         'manuais.*.nome' => 'required',
         'manuais.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
         'textosAlternativos.*.textoAlternativo' => 'required',
         'fotos.*' => 'required|mimetypes:image/jpeg,image/png|dimensions:min_width=200,min_height=150,max_width=800,max_height=600|max:2048',
         'fotoDestaque' => 'required',
         'contato_email' => ['nullable', 'email'],
         'contato_telefone' => ['nullable', 'max:15', 'min:14'],
     ];

     $mensagens = [
        'titulo.required' => 'É preciso informar um título para a Tecnologia Assistiva',
        'titulo.max' => 'O título deve ter menos de 256 caracteres',
        'descricao.required'  => 'Descreva brevemente o que está cadastrando',
        //'siteFabricante.required' => 'Informe o site do recurso',
        'siteFabricante.url' => 'Informe um endereço válido (ex: https://www.meusite.com.br)',
        'produtoComercial.required' => 'Marque se é um produto comercial ou não',
        'licenca.max' => 'Informe a licença em usando menos de 256 caracteres',
        // 'licenca.required_if' => 'Informe a licença de distribuição desse recurso',
        'tags.required' => 'Informe ao menos uma tag',
        'videos[].regex' => 'Endereço inválido, fora dos padrões',
        'arquivos.*.nome.required' => 'Informe o nome do arquivo',
        'arquivos.*.formato' => 'Informe o formato do arquivo',
        'arquivos.*.tamanho' => 'Informe o tamanho do arquivo (em Megabytes)',
        'arquivos.*.url.required' => 'Informe o endereço de acesso ao arquivo',
        'arquivos.*.url.regex' => 'O endereço de acesso ao arquivo é inválido',
        'manuais.*.nome.required' => 'Informe o nome do manual',
        'manuais.*.formato' => 'Informe o formato do manual',
        'manuais.*.tamanho' => 'Informe o tamanho do manual (em Megabytes)',
        'manuais.*.url.required' => 'Informe o endereço de acesso ao manual',
        'manuais.*.url.regex' => 'O endereço de acesso ao arquivo é inválido',
        'textosAlternativos.*.textoAlternativo.required' => 'Informe o texto alternativo para a imagem',
        'textosAlternativos.*.textoAlternativo.max' => 'O texto alternativo deve ter menos de 255 caracteres',
        'fotos.*.mimetypes' => 'A foto deve ser ou jpeg, ou jpg, ou png.',
        'fotos.*.dimensions' => 'As fotos devem estar dimensionadas com a largura entre 200 e 800 pixels e a altura entre 150 e 600 pixels',
        'fotos.*.max' => 'O tamanho das fotos deve ser de no máximo 2MB',
        'fotoDestaque.required' =>  'Escolha uma foto para ser exibida primeiro ao listar a tecnologia assistiva',
        'contato_telefone.*' => 'Informe um telefone válido, ex: (012) 91234-4567',
        'contato_email.email' => 'Informe um e-mail válido',
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
    $recursoTA->licenca = request('licenca');

    $recursoTA->site_fabricante = request('siteFabricante');

    if (request('enviar') === 'publicar') {
        $recursoTA->publicacao_autorizada = true;
    }
    
    $recursoTA->contato_nome = request('contato_nome');
    $recursoTA->contato_email = request('contato_email');
    $recursoTA->contato_telefone = preg_replace('/\D/', '', request('contato_telefone'));
    $recursoTA->contato_instituicao = request('contato_instituicao');
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
            $fotoEmProcessamento->destroy();

            $fotoRedimensionada->save(storage_path('app/public/uploads/').$novoNomeFoto);
            $fotoRedimensionada->destroy();

            //Processa a imagem para criar a thumbnail
            $thumbnailFoto = Image::make($foto);

            $larguraMaximaThumbail = 200; //px_close(pxdoc)
            $alturaMaximaThumbnail = 150; //px

            $thumbnailFoto->resize($larguraMaximaThumbail, $alturaMaximaThumbnail, function ($constraint) {
                $constraint->aspectRatio();
            });

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
            $novoArquivo->link_externo = isset($arquivo['link_externo']);
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
            $novoManual->link_externo = isset($manual['link_externo']);
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

    $this->removeUploadContributions($recursoAlvo);

    RecursoTA::destroy($idRecursoTA);

    return redirect('/administrarRecursosTA')->with(
        "sucessoExclusao" , "Informações excluídas do RETACE com sucesso!"
    );
}

    private function removeUploadContributions($recursoTA) {
        foreach ($recursoTA->uploads as $upload) {
            $fileFullPath = public_path($upload->arquivo);
            if ($upload->arquivo && File::exists($fileFullPath)) {
                File::delete($fileFullPath);
            }
        }
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
         'siteFabricante' => [/*'required'*/ 'nullable', 'url'],
         'produtoComercial' => 'required',
         'licenca' => 'max:255',
         'tags' => 'required',
         'videos.*.url' => ['sometimes','url'],
         'arquivos.*.nome' => 'required',
         'arquivos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
         'manuais.*.nome' => 'required',
         'manuais.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
         'textosAlternativos.*.textoAlternativo' => 'required',
         'fotos.*' => 'required|mimetypes:image/jpeg,image/png|dimensions:min_width=200,min_height=150,max_width=800,max_height=600|max:2048',
         'fotoDestaque' => 'required',
         'contato_email' => ['nullable', 'email'],
         'contato_telefone' => ['nullable', 'max:15', 'min:14'],
     ];

     $mensagens = [
        'titulo.required' => 'É preciso informar um título para a Tecnologia Assistiva',
        'titulo.max' => 'O título deve ter menos de 256 caracteres',
        'descricao.required'  => 'Descreva brevemente o que está cadastrando',
        'siteFabricante.required' => 'Informe o site do recurso',
        'siteFabricante.url' => 'Informe um endereço válido (ex: https://www.meusite.com.br)',
        'produtoComercial.required' => 'Marque se é um produto comercial ou não',
        'licenca.max' => 'Informe a licença em usando menos de 256 caracteres',
        'tags.required' => 'Informe ao menos uma tag',
        'videos[].regex' => 'Endereço inválido, fora dos padrões',
        'arquivos.*.nome.required' => 'Informe o nome do arquivo',
        // 'arquivos.*.formato.required' => 'Informe o formato do arquivo',
        // 'arquivos.*.tamanho.required' => 'Informe o tamanho do arquivo (em Megabytes)',
        'arquivos.*.url.required' => 'Informe o endereço de acesso ao arquivo',
        'arquivos.*.url.regex' => 'O endereço de acesso ao arquivo é inválido',
        'manuais.*.nome.required' => 'Informe o nome do manual',
        // 'manuais.*.formato.required' => 'Informe o formato do manual',
        // 'manuais.*.tamanho.required' => 'Informe o tamanho do manual (em Megabytes)',
        'manuais.*.url.required' => 'Informe o endereço de acesso ao manual',
        'manuais.*.url.regex' => 'O endereço de acesso ao arquivo é inválido',
        'textosAlternativos.*.textoAlternativo.required' => 'Informe o texto alternativo para a imagem',
        'textosAlternativos.*.textoAlternativo.max' => 'O texto alternativo deve ter menos de 255 caracteres',
        'fotos.required' => 'Faça o upload de ao menos uma foto do recurso',
        'fotos.*.mimetypes' => 'A foto deve ser ou jpeg, ou jpg, ou png.',
        'fotos.*.dimensions' => 'As fotos devem estar dimensionadas com a largura entre 200 e 800 pixels e a altura entre 150 e 600 pixels',
        'fotos.*.max' => 'O tamanho das fotos deve ser de no máximo 2MB',
        'fotoDestaque.required' =>  'Escolha uma foto para ser exibida primeiro ao listar a tecnologia assistiva',
        'contato_telefone.*' => 'Informe um telefone válido, ex: (012) 91234-4567',
        'contato_email.email' => 'Informe um e-mail válido',
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
    $recursoTA->licenca = request('licenca');

    $recursoTA->site_fabricante = request('siteFabricante');
    //Por estar autenticado como admin, cadastra já com a autorização
    $recursoTA->publicacao_autorizada = true;
    $recursoTA->contato_nome = request('contato_nome');
    $recursoTA->contato_email = request('contato_email');
    $recursoTA->contato_telefone = preg_replace('/\D/', '', request('contato_telefone'));
    $recursoTA->contato_instituicao = request('contato_instituicao');
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
            $novoArquivo->link_externo = isset($arquivo['link_externo']);
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
            $novoManual->link_externo = isset($manual['link_externo']);
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
        $conteudoPagina = Pagina::where('nome', 'LIKE' ,'Aprender')->firstOrCreate([
            'nome' => 'Aprender'
        ]);
        return view('editarPaginaAprender',['conteudoPagina' => $conteudoPagina]);
    }

    /**
     * Encaminha para o formulário de edição de conteúdo da página 'Sobre'
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editarPaginaSobre()
    {
        $conteudoPagina = Pagina::where('nome', 'LIKE', 'Sobre')->firstOrCreate([
            'nome' => 'Sobre'
        ]);
        return view('editarPaginaSobre',['conteudoPagina' => $conteudoPagina]);
    }


    private function salvarEdicaoPagina(Request $request, Pagina $pagina)
    {
        $regras = [
            'titulo' => 'required|max:255',
            'descricao' => 'required',
        ];

        $mensagens = [
            'titulo.required' => 'É preciso informar um título para o texto da página',
            'titulo.max' => 'O título deve ter menos de 256 caracteres',
            'descricao.required'  => 'A página deve possuir um texto ',
        ];

        $validador = Validator::make($request->all(),$regras,$mensagens);

        //Retorna mensagens de validação no formato JSON caso haja problemas
        if($validador->fails()){
            return response()->json($validador->messages(), 422);
        }

        $pagina->titulo_texto = request('titulo');
        $pagina->texto = request('descricao');

        $pagina->save();

        return response()->json("Edição publicada com sucesso!", 200);
    } 

    /**
     * Processo o formulário de edição de conteúdo da página 'Aprender'
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function salvarEdicaoPaginaAprender(Request $request)
    {
        return $this->salvarEdicaoPagina($request, Pagina::where('nome', 'LIKE', 'Aprender')->first());
    } 

/**
     * Processo o formulário de edição de conteúdo da página 'Sobre'
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function salvarEdicaoPaginaSobre(Request $request)
    {
        return $this->salvarEdicaoPagina($request, Pagina::where('nome', 'LIKE', 'Sobre')->first());    
    } 

    /**
     * Encaminha para a página onde todos os usuários cadastrados
     * serão listados.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function administrarUsuarios()
    {
        if(!Gate::allows('manage-users')) return redirect('home');
        $usuarios = User::all();
        return view('administrarUsuarios', ['usuarios' => $usuarios, 
                    'usuarioAtualId' => Auth::user()->id]);
    }


    /**
     * Encaminha para a página com o formulário de cadastro do usuário
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adicionarUsuario()
    {
        if(!Gate::allows('manage-users')) return redirect('home');
        return view('adicionarUsuario');
    }


    /**
     * Processa o form de cadastro de usuário
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cadastrarUsuario(Request $request)
    {
        if(!Gate::allows('manage-users', Auth::user())) return redirect('home');

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

        try {
            $this->enviaEmailNovoUsuario($novoUsuario,$senhaGerada);
        } catch (\Exception $e) {
            return response()->json("Usuário cadastrado, mas não foi possível enviar o e-mail de boas vindas", 422);    
        }

        return response()->json("Usuário cadastrado com sucesso. Deseja adicionar outro ou retornar à administração de usuários?");
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
        if(!Gate::allows('manage-users')) return redirect('home');
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
        if(!Gate::allows('manage-user', $idUsuario)) return response()->json("Ação inválida, somente o próprio usuário pode ediatr suas informações", 422);

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
                        'password.required' => 'Informe a nova senha',
                        'password.confirmed' => 'A nova senha não confere com a confirmação',
                        'password.min' => 'Informe uma senha com no mínimo 6 caracteres'
                    ];

         $validador = Validator::make($request->all(),$regras,$mensagens)
            ->sometimes('password', ['sometimes', 'required', 'confirmed', 'min:6'], function ($input) {
                return $input->password !== null;
            });

         //Retorna mensagens de validação no formato JSON caso haja problemas
        if($validador->fails()){
            return response()->json($validador->messages(), 422);
        }

        $usuarioEditado = User::findOrFail($idUsuario);
        $usuarioEditado->name = $request->name;
        $oldEmail = $usuarioEditado->email;
        $usuarioEditado->email = $request->email;
    
        if ($request->password !== null) {
            $usuarioEditado->password = Hash::make($request->password);
        }

        $usuarioEditado->save();

        if($usuarioEditado->email != $oldEmail){
            try {
                $this->enviaEmailAlteracaoConta($oldEmail,$usuarioEditado);
            } catch (\Exception $e) {
                return response()->json("Usuário atualizado, mas não foi possível enviar e-mail informativo", 422);        
            }
        }
        
        return response()->json("Usuário editado com sucesso!");
    }

    /**
     * Método acessório para enviar mensagens aos endereços de e-mail antigo e novo para
     * notificar a alteração.
     */
    private function enviaEmailAlteracaoConta($emailAntigo,User $usuarioEditado){
        $to_name = $usuarioEditado->name;
        $emailNovo = $usuarioEditado->email;
        $data = array('nomeUsuario'=> $usuarioEditado->name, 'emailNovo' => $usuarioEditado->email, 'emailAntigo' => $emailAntigo);

        Mail::send('emailAlteracaoContaUsuario', $data, function($message) use ($to_name, $emailAntigo) {
            $message->to($emailAntigo, $to_name)
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

        try {
            $this->enviaEmailRecuperacaoSenha($usuario,$senhaGerada);
        } catch (\Exception $e) {
            return redirect('/administrarUsuarios')->with('warn', "Não foi possível enviar o e-mail de recuperação de senha para o usuário {$usuario->name}");
        }

        return redirect('/administrarUsuarios')->with('info', "Recuperação e envio de senha para o usuário {$usuario->name} concluídos com sucesso!");
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
        if(!Gate::allows('manage-users')) return redirect('home');

        $usuario = User::findOrFail($request->idUsuario);
        User::destroy($request->idUsuario);

        try {
            $this->enviaEmailExclusaoConta($usuario);
        } catch (\Exception $e) {
            return response()->json("Exclusão realizada mas não foi possível enviar notificação por e-mail");            
        }

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

    public function excluirUploadContribuicao($uploadId) {
        $upload = Upload::findOrFail($uploadId);
        if ($upload) {
            $fileFullPath = public_path($upload->arquivo);        
            if ($upload->arquivo && File::exists($fileFullPath)) {
                File::delete($fileFullPath);
            }

            Upload::destroy($uploadId);
        }

        return back();
    }
}

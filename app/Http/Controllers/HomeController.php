<?php

namespace App\Http\Controllers;

// include composer autoload
require '../vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Image;
use App\RecursoTA;
use App\Tag;
use App\Video;
use App\Arquivo;
use App\Manual;
use App\Foto;

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

        /*return redirect('/administrarRecursosTA')->with([
                'feedback' =>  $mensagemExclusaoFotos." ".$mensagemExclusaoBanco
                ]);*/
        return redirect('/administrarRecursosTA');
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
           'videos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
           'arquivos.*.*' => 'sometimes | required',
           'arquivos.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
           'manuais.*.*' => 'sometimes | required',
           'manuais.*.url' => ['sometimes','regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
           'textosAlternativos.*.textoAlternativo' => 'required',
           'fotos.*.*' => 'required|mimes:jpg,png',
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
        foreach ($fotosCarregadas as $foto) {
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
            $nomeArquivoSanitizado = str_replace(str_split("()"),'_',trim($foto->getClientOriginalName()));
            if($nomeArquivoSanitizado==request('fotoDestaque')){
                $novaFoto->destaque = true;
            }else{
                $novaFoto->destaque = false;
            }

            //O nome do arquivo é a chave para acessar o texto alternativo
            $indiceTextoAlternativo = $nomeArquivoSanitizado;
            $novaFoto->texto_alternativo = $textosAlternativos[$indiceTextoAlternativo]['textoAlternativo'];
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
}

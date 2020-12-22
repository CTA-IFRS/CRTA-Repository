<?php

namespace App\Http\Controllers;

use App\RecursoTA;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;   

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
        $tagAlvo = Tag::find($idTag);
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
        $tagAlvo = Tag::find($idTag);
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
        $tagAlvo = Tag::find($idTag);

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

    $tagAlvo = Tag::find($request->idTag);
    $tagAlvo->nome = $request->nomeTag;
    $tagAlvo->publicacao_autorizada = $tagAlvo->publicacao_autorizada; 
    $tagAlvo->save();

    $tags = Tag::all();
    return view('administrarTags', ['tags' => $tags]);
}
}

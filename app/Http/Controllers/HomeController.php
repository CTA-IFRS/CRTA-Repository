<?php

namespace App\Http\Controllers;

use App\RecursoTA;
use App\Tag;
use Illuminate\Http\Request;

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
}

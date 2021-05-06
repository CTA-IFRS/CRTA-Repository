<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//In a route, the first parameter is the url and the second parameter can be a callback or controller action. 
// syntax: 'ControllerName@MethodName'
//Rotas de autenticação
Auth::routes();
//Home
Route::get('/', 'NavegacaoController@inicio');
//Rotas das funcionalidades do Admin
Route::get('/entrar', 'NavegacaoController@login');
//Administração de Usuários
Route::get('/painelAdministrador', 'HomeController@index');
Route::get('/administrarUsuarios', 'HomeController@administrarUsuarios');
Route::get('/adicionarUsuario', 'HomeController@adicionarUsuario');
Route::post('/cadastrarUsuario', 'HomeController@cadastrarUsuario')->name('cadastrarUsuario');
Route::get('/editarUsuario/{idUsuario}', 'HomeController@editarUsuario');
Route::post('atualizarUsuario/{idUsuario}','HomeController@atualizarUsuario')->name('atualizarUsuario');
Route::get('/informacoesUsuario','HomeController@informacoesUsuario');
Route::post('/excluirUsuario','HomeController@excluirUsuario')->name('excluirUsuario');
Route::get('/recuperarSenha/{idUsuario}','HomeController@recuperarSenha');

Route::get('/administrarRecursosTA', 'HomeController@administrarRecursosTA');
Route::get('/administrarTags', 'HomeController@administrarTags');
Route::get('/autorizaPublicacaoTag/{idTag}', 'HomeController@autorizaPublicacaoTag');
Route::get('/omitirPublicacaoTag/{idTag}', 'HomeController@omitirPublicacaoTag');
Route::get('/editarTag/{idTag}', 'HomeController@editarTag');
Route::get('/revisarRecursoTA/{idRecursoTA}', 'HomeController@revisarRecursoTA');
Route::get('/adicionarRecursoTA', 'HomeController@adicionarRecursoTA');
Route::get('/autorizarPublicacaoRecursoTA/{idRecursoTA}', 'HomeController@autorizarPublicacaoRecursoTA');
Route::get('/omitirRecursoTA/{idRecursoTA}', 'HomeController@omitirRecursoTA');
Route::get('/excluirRecursoTA/{idRecursoTA}', 'HomeController@excluirRecursoTA');
Route::get('/editarPaginaAprender','HomeController@editarPaginaAprender');
Route::get('/editarPaginaSobre','HomeController@editarPaginaSobre');
//Rotas das funcionalidades dos RecursosTA
//Implicit binding para retornar modelo com {idRecursoTA} no banco. Se não encontrar nada, retornar erro 404.
Route::get('/exibeRecursoTA/{idRecursoTA}', 'NavegacaoController@exibeRecursoTA');
Route::get('/aprender', 'NavegacaoController@exibePaginaAprender');
Route::get('/sobre', 'NavegacaoController@exibePaginaSobre');
Route::get('buscaRecursoTAPorTermo', ['as' => 'buscaRecursoTAPorTermo', 'uses' => 'NavegacaoController@buscaRecursoTAPorTermo']);

//Filtro para saber qual busca realizar ao consultar TAs
Route::get('/filtro', function(Illuminate\Http\Request $request) {
	if(strcmp($request['tipoBusca'],"tags")===0){
		return redirect()->route('buscaPorTag', ['tag' => $request['termo'] ]);
	}else if(strcmp($request['tipoBusca'],"termo")===0){
		return redirect()->route('buscaPorTermo', ['termo' => $request['termo'] ]);
	}else{
		return redirect()->route('buscaTodos');
	}
})->name('filtro');

Route::get('/buscaRecursoTAPorTag/{tag?}', 'NavegacaoController@buscaRecursoTAPorTag')->name('buscaPorTag');
Route::get('/buscaRecursoTAPorTermo/{termo?}', 'NavegacaoController@buscaRecursoTAPorTermo')->name('buscaPorTermo');
Route::get('/buscaPorTodosRecursosTA', 'NavegacaoController@buscaPorTodosRecursosTA')->name('buscaTodos');
Route::get('/cadastrarTA','RecursoTAController@create');
Route::get('/listarTA','RecursoTAController@retrieveAll');
Route::get('/listaCardsRecursos','RecursoTAController@atualizaListaAssincronamente');

//Rotas para processamento de forms devem ser nomeadas
Route::post('salvaTA','RecursoTAController@store')->name('salvaTA');
Route::post('salvaEdicaoTag','HomeController@salvaEdicaoTag')->name('salvaEdicaoTag');
Route::post('insereRecursoTA','HomeController@insereRecursoTA')->name('insereRecursoTA');
Route::post('/editarRecursoTA/{idRecursoTA}','HomeController@editarRecursoTA')->name('editarRecursoTA');
Route::post('/removeFoto/{idFoto}','HomeController@removeFoto');
Route::post('salvarEdicaoPaginaAprender','HomeController@salvarEdicaoPaginaAprender')->name('salvarEdicaoPaginaAprender');
Route::post('salvarEdicaoPaginaSobre','HomeController@salvarEdicaoPaginaSobre')->name('salvarEdicaoPaginaSobre');
Route::post('avaliarRecursoTA', 'RecursoTAController@avaliarRecursoTA')->name('avaliarRecursoTA');


//Rota para envio de email
Route::get('/send/emailNovoRecursoTA/{idRecursoTA}', 'HomeController@emailNovoRecursoTA');
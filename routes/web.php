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
Route::get('/painel-administrador', 'HomeController@index')->name('painelAdministrador');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/administrar/usuarios', 'HomeController@administrarUsuarios')->name('administrarUsuarios');
Route::get('/administrar/adicionar-usuario', 'HomeController@adicionarUsuario')->name('adicionarUsuario');
Route::post('/administrar/cadastrar-usuario', 'HomeController@cadastrarUsuario')->name('cadastrarUsuario');
Route::get('/administrar/editar/usuario/{idUsuario}', 'HomeController@editarUsuario')->name('editarUsuario');
Route::post('/administrar/atualizar/usuario/{idUsuario}','HomeController@atualizarUsuario')->name('atualizarUsuario');
Route::get('/administrar/informacoes/usuario','HomeController@informacoesUsuario')->name('informacoesUsuario');
Route::post('/administrar/excluir/usuario','HomeController@excluirUsuario')->name('excluirUsuario');
Route::get('/recuperar-senha/usuario/{idUsuario}','HomeController@recuperarSenha')->name('recuperarSenha');

// Admininstrar tags e recursos
Route::get('/administrar/recursos-ta', 'HomeController@administrarRecursosTA')->name('administrarRecursosTA');
Route::get('/administrar/tags', 'HomeController@administrarTags')->name('administrarTags');
Route::get('/administrar/autorizar/publicacao/tag/{idTag}', 'HomeController@autorizaPublicacaoTag')->name('autorizaPublicacaoTag');
Route::get('/administrar/omitir/tag/{idTag}', 'HomeController@omitirPublicacaoTag')->name('omitirPublicacaoTag');
Route::get('/administrar/editar/tag/{idTag}', 'HomeController@editarTag')->name('editarTag');
Route::get('/administrar/remover/tag/{idTag}', 'HomeController@removerTag')->name('removerTag');
Route::get('/administrar/revisar/recurso-ta/{idRecursoTA}', 'HomeController@revisarRecursoTA')->name('revisarRecursoTA');
Route::get('/administrar/adicionar/recurso-ta', 'HomeController@adicionarRecursoTA')->name('adicionarRecursoTA');
Route::get('/administrar/autorizar/publicacao/recurso-ta/{idRecursoTA}', 'HomeController@autorizarPublicacaoRecursoTA')->name('autorizarPublicacaoRecursoTA');
Route::get('/administrar/omitir/recurso-ta/{idRecursoTA}', 'HomeController@omitirRecursoTA')->name('omitirRecursoTA');
Route::get('/administrar/excluir/recurso-ta/{idRecursoTA}', 'HomeController@excluirRecursoTA')->name('excluirRecursoTA');
Route::get('/administrar/excluir/upload/{idUpload}', 'HomeController@excluirUploadContribuicao')->name('excluirUpload');
Route::get('/administrar/editar/pagina-aprender','HomeController@editarPaginaAprender')->name('editarPaginaAprender');
Route::get('/administrar/editar/pagina-sobre','HomeController@editarPaginaSobre')->name('editarPaginaSobre');
//Rotas das funcionalidades dos RecursosTA
//Implicit binding para retornar modelo com {idRecursoTA} no banco. Se não encontrar nada, retornar erro 404.
//Route::get('/exibeRecursoTA/{idRecursoTA}', 'NavegacaoController@exibeRecursoTA')->name('exibeRecursoTA');
Route::get('/recurso-ta/{slug}', 'NavegacaoController@exibeRecursoTA_slug')->name('exibeRecursoTASlug');

Route::get('/aprender', 'NavegacaoController@exibePaginaAprender');
Route::get('/sobre', 'NavegacaoController@exibePaginaSobre');
Route::get('/acessibilidade', 'NavegacaoController@exibePaginaAcessibilidade')->name('acessibilidade');
Route::get('/mapa-do-site', 'NavegacaoController@exibePaginaMapaDoSite')->name('mapaDoSite');
Route::get('/buscar/recurso-ta/termo', ['as' => 'buscaRecursoTAPorTermo', 'uses' => 'NavegacaoController@buscaRecursoTAPorTermo'])->name('buscaRecursoTAPorTermo');

Route::get('/filtro/tag/{tag}', 'NavegacaoController@buscaRecursoTAPorTag')->name('filtroTag');
Route::get('/filtro/texto/{texto}', 'NavegacaoController@buscarPorTexto')->name('filtro');
Route::get('/filtro/texto', 'NavegacaoController@inicio');
Route::post('/filtro/texto', 'NavegacaoController@buscarPorTexto')->name('filtroPost');

Route::get('/recursos-ta', 'NavegacaoController@buscaPorTodosRecursosTA')->name('verTodosOsRecursos');
Route::get('/contribuir-ta','RecursoTAController@create')->name('cadastrarTA');
Route::get('/listar-tas','RecursoTAController@retrieveAll')->name('listarTA');
Route::get('/listar/cards-recursos','RecursoTAController@atualizaListaAssincronamente')->name('listaCardsRecursos');

//Rotas para processamento de forms devem ser nomeadas
Route::post('/contribuir/salvar/recurso-ta','RecursoTAController@store')->name('salvaTA');
Route::post('/administrar/salvar/tag','HomeController@salvaEdicaoTag')->name('salvaEdicaoTag');
Route::post('/administrar/adicionar/recurso-ta','HomeController@insereRecursoTA')->name('insereRecursoTA');
Route::post('/administrar/revisar/recurso-ta/{idRecursoTA}','HomeController@editarRecursoTA')->name('editarRecursoTA');
Route::post('/remover/foto/{idFoto}','HomeController@removeFoto')->name('removeFoto');
Route::post('/administrar/salvar/pagina/aprender','HomeController@salvarEdicaoPaginaAprender')->name('salvarEdicaoPaginaAprender');
Route::post('/administrar/salvar/pagina/sobre','HomeController@salvarEdicaoPaginaSobre')->name('salvarEdicaoPaginaSobre');
Route::post('/avaliar/recurso-ta', 'RecursoTAController@avaliarRecursoTA')->name('avaliarRecursoTA');

Route::post('criar-slug', 'HomeController@makeSlugForTitulo')->name('criarSlug');
//Rota para envio de email
//Route::get('/send/emailNovoRecursoTA/{idRecursoTA}', 'HomeController@emailNovoRecursoTA');
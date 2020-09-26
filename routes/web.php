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

Route::get('/', 'NavegacaoController@inicio');
Route::get('/entrar', 'NavegacaoController@login');
Route::get('/registrar', 'NavegacaoController@cadastroUsuario');
Route::get('/painelUsuario', 'HomeController@index');

//Implicit binding para retornar modelo com {idRecursoTA} no banco. Se não encontrar nada, retornar erro 404.
Route::get('/exibeRecursoTA/{idRecursoTA}', 'NavegacaoController@exibeRecursoTA');
//Rotas de autenticação
Auth::routes();

Route::get('/cadastrarTA','RecursoTAController@create');
Route::get('/listarTA','RecursoTAController@retrieveAll');
Route::get('/listaCardsRecursos','RecursoTAController@atualizaListaAssincronamente');
//Routes para controllers que irão processar forms devem ser nomeadas
Route::post('salvaTA','RecursoTAController@store')->name('salvaTA');


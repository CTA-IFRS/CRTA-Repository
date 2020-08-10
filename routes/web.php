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
Route::get('/semIcone', 'NavegacaoController@inicioSemIcone');

Auth::routes();
Route::get('/entrar', 'NavegacaoController@login');
Route::get('/registrar', 'NavegacaoController@cadastroUsuario');
Route::get('/painelUsuario', 'HomeController@index');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\RecursosTA;
use App\RecursoTA;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Implementa a API que o SAAPNE usará para solicitar todos os recursos cadastrados
 * no RETACE que já foram aprovados pela administração.
 * @return Json
 */
Route::get('/recursosTA', function () {
    return new RecursosTA(RecursoTA::where('publicacao_autorizada',true)->orderBy('visualizacoes', 'desc')->get());
});
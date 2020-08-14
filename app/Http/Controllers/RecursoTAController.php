<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecursoTA;

class RecursoTAController extends Controller
{
    public function salvarRecursoTA(Request $request) {


    	//Valida os campos submetidos no formulario
    	$this->validate($request, [
        	'titulo' => 'required|max:255',
        	'descricao' => 'required|max:1020',
        	'siteFabricante' => 'required|max:2048',
        	'produtoComercial' => 'required',
        	'licenca' => 'nullable|max:255'
    	], [
      		'titulo.required' => 'É preciso informar um título para a Tecnologia Assistiva',
      		'titulo.max' => 'O título deve ter menos de 256 caracteres',
      		'descricao.required'  => 'Descreva brevemente o que está cadastrando',
      		'siteFabricante.required' => 'Informe um site do fabricante ou instituição',
      		'produtoComercial.required' => 'Marque se é um produto comercial ou não',
      		'licenca.max' => 'Informe a licença em usando menos de 256 caracteres'
    	]);

    	//Caso esteja tudo ok, prepara para criar no DB
   		$novoRecurso = [
   			'titulo' => request('titulo'),
   			'descricao' => request('descricao'),
   			'produtoComercial' => request('produtoComercial'),
   			'siteFabricante' => request('siteFabricante'),
   			'licenca' => request('licenca'),
   			'publicacaoAutorizada' => false
   		];

   		//Cria no DB
   		RecursoTA::create($novoRecurso);

   		return redirect('recursosTA');
    }
}

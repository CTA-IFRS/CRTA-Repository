<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecursoTA;
use App\Tag;

class RecursoTAController extends Controller
{
    public function store(Request $request) {


    	//Valida os campos submetidos no formulario
    	$this->validate($request, [
        	'titulo' => 'required|max:255',
        	'descricao' => 'required|max:1020',
        	'siteFabricante' => 'required|max:2048',
        	'produtoComercial' => 'required',
        	'licenca' => 'nullable|max:255',
          'tags' => 'required'
    	], [
      		'titulo.required' => 'É preciso informar um título para a Tecnologia Assistiva',
      		'titulo.max' => 'O título deve ter menos de 256 caracteres',
      		'descricao.required'  => 'Descreva brevemente o que está cadastrando',
      		'siteFabricante.required' => 'Informe um site do fabricante ou instituição',
      		'produtoComercial.required' => 'Marque se é um produto comercial ou não',
      		'licenca.max' => 'Informe a licença em usando menos de 256 caracteres',
          'tags' => 'Marque ao menos uma categoria para o recurso'
    	]);

    	//Caso esteja tudo ok, prepara para criar no DB

      $recursoTA = new RecursoTA();
      $recursoTA->titulo = request('titulo');
      $recursoTA->descricao = request('descricao');
      $recursoTA->produtoComercial = request('produtoComercial');
      $recursoTA->siteFabricante = request('siteFabricante');
      $recursoTA->licenca = request('licenca');
      $recursoTA->publicacaoAutorizada = false;
      $recursoTA->tags()->attach(request('tags'));
     /* 
   		$novoRecurso = [
   			'titulo' => request('titulo'),
   			'descricao' => request('descricao'),
   			'produtoComercial' => request('produtoComercial'),
   			'siteFabricante' => request('siteFabricante'),
   			'licenca' => request('licenca'),
   			'publicacaoAutorizada' => false
   		];*/

   		//Cria no DB
   		RecursoTA::create($recursoTA);

   		return redirect('recursosTA');
    }

    /* Popula o form com as tags cadastradas para depois encaminhar para a view do formulário
     *
     *  @return \Illuminate\Http\Response
     */
    public function create(){

      $tags = Tag::all(['id','nome','descricao']);
      return view('cadastrarTA',compact('tags'));
    }
}

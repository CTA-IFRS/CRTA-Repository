<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecursoTA;
/**
 * Classe para efetuar a navegação entre as páginas do RETACE
 */

class NavegacaoController extends Controller{
	/** 
	 * Exibe a tela inicial
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function inicio(Request $request){
		
		$recursosTA = RecursoTA::paginate(10);
		return view('inicio',['recursosTA' => $recursosTA]);
	}

	/** 
	 * Exibe a tela de login 
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function login(){
		return view('auth.login');
	}


	/** 
	 * Exibe a tela de cadastro de usuário
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function cadastroUsuario(){
		return view('auth.register');
	}

	/** 
	 * Exibe a tela do painel do usuário
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function painelUsuario(){
		return view('painelUsuario');
	}		

	/** 
	 * Exibe a tela de cadastro de Tecnologia Assistiva
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function cadastroTA(){
		return view('cadastrarTA');
	}		
}
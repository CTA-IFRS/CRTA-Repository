<?php

namespace App\Http\Controllers;

/**
 * Classe para efetuar a navegação entre as páginas do RETACE
 */

class NavegacaoController extends Controller{
	/** 
	 * Exibe a tela inicial
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function inicio(){
		return view('inicio');
	}

	/** 
	 * Exibe a tela inicial com texto ao invés dos ícones das redes sociais
	 *
	 *	@return \Illuminate\Contracts\Support\Renderable
	 */	
	public function inicioSemIcone(){
		return view('inicioSemIcone');
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
	 * Exibe a tela de cadastro 
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
}
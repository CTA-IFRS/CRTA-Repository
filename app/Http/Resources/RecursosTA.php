<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Tags;
use App\Http\Resources\Videos;
use App\Http\Resources\Fotos;

class RecursosTA extends ResourceCollection
{

	private $recursosTA = [];
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

    	$this->collection->each(function($recursoTA, $key){

    		$aux = 	[ 'titulo' => $recursoTA->titulo,
                 	'descricao' => $recursoTA->descricao,
                 	'produto_comercial' => $recursoTA->produto_comercial,
               	  	'site_fabricante' => $recursoTA->site_fabricante,
               	 	'licenca' => $recursoTA->licenca,
                 	'visualizacoes' => $recursoTA->visualizacoes,
                 	'tags' => new Tags($recursoTA->tags),
                 	'videos' => new Videos($recursoTA->videos),
                 	'fotos' => new Fotos($recursoTA->fotos),
                 	'arquivos' => new Arquivos($recursoTA->arquivos),
                 	'manuais' => new Manuais($recursoTA->manuais)];

    		array_push($this->recursosTA,$aux);
    	});

    	return [
    		'meta' => ['total_recursosTA' => $this->collection->count()],
    		'recursosTA' => $this->recursosTA	
    	];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Arquivos extends ResourceCollection
{
    private $arquivos = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function($arquivo, $key){
            $aux =  [   'url' => $arquivo->url,
                        'nome' => $arquivo->nome ,
                        'formato' => $arquivo->formato,
                        'tamanho_em_mb' => $arquivo->tamanho ];

            array_push($this->arquivos,$aux);
        });

        return [
            'meta' => ['total_arquivos' => $this->collection->count()],
            'arquivos' => $this->arquivos   
        ];
    }
}

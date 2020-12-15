<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Manuais extends ResourceCollection
{
    private $manuais = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function($manual, $key){
            $aux =  [   'url' => $manual->url,
                        'nome' => $manual->nome ,
                        'formato' => $manual->formato,
                        'tamanho_em_mb' => $manual->tamanho ];
                        
            array_push($this->manuais,$aux);
        });

        return [
            'meta' => ['total_manuais' => $this->collection->count()],
            'manuais' => $this->manuais   
        ];
    }
}

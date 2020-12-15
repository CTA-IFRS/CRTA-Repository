<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class Fotos extends ResourceCollection
{
    private $fotos = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function($foto, $key){
            $aux =  [ 'destaque' => $foto->destaque,
                      'texto_alternativo' => $foto->texto_alternativo,
                      'url_arquivo' => Storage::url('public/'.$foto->caminho_arquivo),
                      'url_thumbnail' => Storage::url('public/'.$foto->caminho_thumbnail)];

            array_push($this->fotos,$aux);
        });

        return [
            'meta' => ['total_fotos' => $this->collection->count()],
            'fotos' => $this->fotos   
        ];
    }
}

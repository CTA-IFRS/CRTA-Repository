<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Tags extends ResourceCollection
{

    private $tags = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function($tag, $key){
            if($tag->publicacao_autorizada==true){
                $aux =  [ 'nome' => $tag->nome];

                array_push($this->tags,$aux);
            }
        });

        return [
            'meta' => ['total_tags' => count($this->tags)],
            'tags' => $this->tags   
        ];
    }
}

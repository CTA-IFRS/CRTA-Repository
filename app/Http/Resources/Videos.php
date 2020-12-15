<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Videos extends ResourceCollection
{
    private $videos = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function($video, $key){
            $aux =  [ 'url' => $video->url];

            array_push($this->videos,$aux);
        });

        return [
            'meta' => ['total_videos' => $this->collection->count()],
            'videos' => $this->videos   
        ];
    }
}

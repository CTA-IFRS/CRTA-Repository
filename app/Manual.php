<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
        'url',
    	'nome',
    	'formato',
    	'tamanho'
    ];

    public function recursoTA()
    {

        return $this->belongsTo('App\RecursoTA');

    }	
}

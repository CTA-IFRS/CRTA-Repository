<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
    	'destaque',
    	'texto_alternativo',
    	'caminho_arquivo',
        'caminho_thumbnail'
    ];

    public function recursoTA()
    {

        return $this->belongsTo('App\RecursoTA');

    }	
}

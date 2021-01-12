<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
    	'nome',
        'titulo_texto',
        'texto'
    ];    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
    	'nome',
    	'descricao',
    	'conteudo',
    	'formato',
    	'tamanho'
    ];

    public function recursoTA()
    {

        return $this->belongsTo('App\RecursoTA');

    }
}

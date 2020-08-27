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
    	'nome',
    	'descricao',
    	'caminhoArquivo',
    	'formato', //permite tornar menos hardcoded caso o requisito do sistema evolua para além de pdf
    	'link'
    ];

    public function recursoTA()
    {

        return $this->belongsTo('App\RecursoTA');

    }	
}

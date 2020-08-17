<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'descricao'
    ];

    /**
     * Retorna os recursos de TA que possuem esta Tag.
     * Estabelece uma parte da relação *:* (Eloquent ORM)
     */
    public function recursosTA()
    {
        return $this->belongsToMany('App\RecursoTA');
    }    
}

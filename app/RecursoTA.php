<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecursoTA extends Model
{

/**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'produtoComercial',
        'siteFabricante',
        'licença',
        'publicacaoAutorizada'
    ];

	//define o nome da tabela do DB porque o padrão do Laravel resultaria em recurso_tas
    protected $table = 'recursos_ta';
}

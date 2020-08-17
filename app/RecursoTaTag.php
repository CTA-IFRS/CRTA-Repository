<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecursoTaTag extends Model
{
    //Classe necessária para setar corretamente o nome da tabela que implemente a relação *:*

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recurso_ta_tag';
}

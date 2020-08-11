<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecursoTA extends Model
{
	//define o nome da tabela do DB porque o padrão do Laravel resultaria em recurso_tas
    protected $table = 'recursos_ta';
}

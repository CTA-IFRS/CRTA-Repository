<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecursoTa extends Model
{

/**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'produto_comercial',
        'site_fabricante',
        'licenca',
        'publicacao_autorizada'
    ];

	//define o nome da tabela do DB porque o padrão do Laravel resultaria em recurso_tas
    protected $table = 'recursos_ta';

    /**
     * Retorna as tags que esse recurso TA possui.
     * Estabelece uma parte da relação *:* (Eloquent ORM)
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag','recurso_ta_tag','recurso_ta_id','tag_id');
    }
}

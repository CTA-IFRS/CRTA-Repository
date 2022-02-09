<?php

namespace App;

use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Model;
use App\UploadTipo;

class RecursoTa extends Model
{
    use Rateable;
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
        'publicacao_autorizada',
        'visualizacoes'
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

    /**
     * Retorna os videos associados ao recurso.
     * Estabelece uma parte da relação 1:* (Eloquent ORM)
     */
    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    /**
     * Retorna os arquivos associados ao recurso.
     * Estabelece uma parte da relação 1:* (Eloquent ORM)
     */
    public function arquivos()
    {
        return $this->hasMany('App\Arquivo');
    }

    /**
     * Retorna os manuais associados ao recurso.
     * Estabelece uma parte da relação 1:* (Eloquent ORM)
     */
    public function manuais()
    {
        return $this->hasMany('App\Manual');
    }

    /**
     * Retorna as fotos associadas ao recurso.
     * Estabelece uma parte da relação 1:* (Eloquent ORM)
     */
    public function fotos()
    {
        return $this->hasMany('App\Foto');
    }

    /**
     * Retorna as tags aprovadas vinculadas ao recurso.
     */
    public function tagsAprovadas() {
        return $this->tags()->where('publicacao_autorizada', true)->get();
    }

    public function uploads() {
        return $this->hasMany('App\Upload');
    }

    public function getUploadArquivos() {
        return $this->uploads->where('upload_tipo_id', UploadTipo::ARQUIVO);
    }

    public function getUploadManuais() {
        return $this->uploads->where('upload_tipo_id', UploadTipo::MANUAL);
    }
}

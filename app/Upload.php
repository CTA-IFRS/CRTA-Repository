<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model {
    protected $fillable = [
    	'arquivo',
        'url_alternativo'
    ];

    public function recursoTA() {
        return $this->belongsTo('App\RecursoTA', 'recurso_ta_id');
    }

    public function tipo() {
        return $this->belongsTo('App\UploadTipo', 'upload_tipo_id');
    }
}
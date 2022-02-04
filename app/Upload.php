<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model {
    protected $fillable = [
    	'arquivo',
        'url_alternativo'
    ];

    public function recursoTA() {
        return $this->belongsTo('App\RecursoTA');
    }

    public function uploadTipo() {
        return $this->hasOne('App\UploadType');
    }
}
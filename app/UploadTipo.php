<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadTipo extends Model {
    public const MANUAL = 1;    // id manual
    public const ARQUIVO = 2;   // id arquivo

    protected $fillable = [
    	'nome'
    ];

    public function uploads() {
        return $this->hasMany('App\Upload');
    }
}
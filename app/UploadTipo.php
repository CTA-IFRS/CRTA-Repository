<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadTipo extends Model {
    protected $fillable = [
    	'nome'
    ];

    public function uploads() {
        return $this->hasMany('App\Upload');
    }
}
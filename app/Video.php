<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
    	'url',
    	'destaque'
    ];

    public function recursoTA()
    {

        return $this->belongsTo('App\RecursoTA');

    }
}

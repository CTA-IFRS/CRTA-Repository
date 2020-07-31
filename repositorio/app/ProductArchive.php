<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductArchive extends Model
{
    protected $fillable = ['file'];

    public  function product()
    {
        return $this->belongsTo(Product::class);
    }
}

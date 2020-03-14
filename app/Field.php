<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function values()
    {
        return $this->hasMany('App\FieldValue');
    }

    public $timestamps = true;

    protected $fillable = [
        'title',
        'type'
    ];
}

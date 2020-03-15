<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public function values()
    {
        return $this->hasMany('App\FieldValue');
    }

    public $timestamps = true;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'state',
    ];
}

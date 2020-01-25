<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /**
     * Get the values for the field.
     */
    public function values()
    {
        return $this->hasMany('App\FieldValue');
    }

    public $timestamps = false;
    protected $fillable = [
        'title',
        'type',
        'created_at',
        'updated_at',
    ];
}

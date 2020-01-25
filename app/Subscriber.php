<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    /**
     * Get the values for the subscriber.
     */
    public function values()
    {
        return $this->hasMany('App\FieldValue');
    }

    public $timestamps = false;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'state',
        'created_at',
        'updated_at',
    ];
}

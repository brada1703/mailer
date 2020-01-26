<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    /**
     * Get the field and subscriber that owns the value.
     */
    public function field()
    {
        return $this->belongsTo('App\Field');
    }

    /**
     * Get the subscriber that owns the value.
     */
    public function subscriber()
    {
        return $this->belongsTo('App\Subscriber');
    }

    public $timestamps = false;

    protected $fillable = [
        // 'subscriber_id',
        // 'field_id',
        'value',
        'created_at',
        'updated_at',
    ];
}

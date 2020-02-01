<?php

namespace App\Rules;

use App\Field;
use Illuminate\Contracts\Validation\Rule;

class ExistingFieldId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $all_field_ids = Field::all()->pluck('id')->toArray();
        return in_array($value, $all_field_ids);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Field ID';
    }
}

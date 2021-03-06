<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailDomainActive implements Rule
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
        $email = explode('@', $value);
        $domain = $email[1];

        return sizeof(dns_get_record($domain)) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid email domain name';
    }
}

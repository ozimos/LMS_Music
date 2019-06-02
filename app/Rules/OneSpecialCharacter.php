<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class OneSpecialCharacter implements Rule
{
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = '/^(?=.*?[#?!@$%^&*-]).{8,}$|.{15}/';
        return preg_match($pattern, $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must contain at least one special character or be at least 15 characters long';
    }
}

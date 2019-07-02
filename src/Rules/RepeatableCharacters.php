<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class RepeatableCharacters.
 *
 * Implements the 'Repeatable characters' recommendation
 * from NIST SP 800-63B section 5.1.1.2.
 */
class RepeatableCharacters implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !preg_match('/(.)\1{2,}/',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('laravel-nist-password-rules::validation.can-not-be-repeatable-characters');
    }
}

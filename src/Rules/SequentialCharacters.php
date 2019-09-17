<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class SequentialCharacters.
 *
 * Implements the 'Sequential characters' recommendation
 * from NIST SP 800-63B section 5.1.1.2.
 */
class SequentialCharacters implements Rule
{
    const PASSWORDS_FILE = __DIR__.'/../../resources/sequential_passwords.txt';

    private $passwords = [];

    /**
     * DictionaryWords constructor.
     */
    public function __construct()
    {
        $this->passwords = explode(PHP_EOL, file_get_contents(self::PASSWORDS_FILE));
    }

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
        return !in_array(strtolower(trim($value)), $this->passwords);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('laravel-nist-password-rules::validation.can-not-be-sequential-characters');
    }
}

<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class DictionaryWords.
 *
 * Implements the 'Dictionary words' recommendation
 * from NIST SP 800-63B section 5.1.1.2.
 */
class DictionaryWords implements Rule
{
    private $words = [];

    /**
     * DictionaryWords constructor.
     */
    public function __construct()
    {
        $dictionaryFile = config('laravel-nist-password-rules.dictionary_words_file_path');

        $this->words = explode("\n", file_get_contents($dictionaryFile));
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
        return !in_array(strtolower(trim($value)), $this->words);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('laravel-nist-password-rules::validation.can-not-be-dictionary-word');
    }
}

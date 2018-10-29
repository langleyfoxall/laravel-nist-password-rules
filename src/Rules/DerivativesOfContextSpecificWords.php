<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class DerivativesOfContextSpecificWords.
 *
 * Implements the 'Context-specific words' recommendation with 'derivatives thereof'.
 * from NIST SP 800-63B section 5.1.1.2.
 */
class DerivativesOfContextSpecificWords extends ContextSpecificWords implements Rule
{
    private $words = [];
    private $detectedWord = null;

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
        $value = strtolower($value);

        foreach ($this->words as $word) {
            if (stripos($value, $word) !== false) {
                return false;
            }

            similar_text($value, $word, $percentage);
            if ($percentage >= 75) {
                $this->detectedWord = $word;
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute can not be similar to the word \''.$this->detectedWord.'\'.';
    }
}

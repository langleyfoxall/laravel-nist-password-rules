<?php

namespace LangleyFoxall\LaravelNISTPasswordRules;

use Illuminate\Validation\Rules\Password;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\ContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DerivativesOfContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DictionaryWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\RepetitiveCharacters;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\SequentialCharacters;

abstract class PasswordRules
{
    public static function register($username, $requireConfirmation = true)
    {
        $rules = [
            'required',
            'string',
            Password::min(8)->uncompromised(),
        ];

        if ($requireConfirmation) {
            $rules[] = 'confirmed';
        }

        return array_merge($rules, [
            new SequentialCharacters(),
            new RepetitiveCharacters(),
            new DictionaryWords(),
            new ContextSpecificWords($username),
            new DerivativesOfContextSpecificWords($username),
        ]);
    }

    public static function changePassword($username, $oldPassword = null)
    {
        $rules = self::register($username);

        if ($oldPassword) {
            $rules = array_merge($rules, [
                'different:'.$oldPassword,
            ]);
        }

        return $rules;
    }

    public static function optionallyChangePassword($username, $oldPassword = null)
    {
        $rules = self::changePassword($username, $oldPassword);

        $rules = array_merge($rules, [
            'nullable',
        ]);

        foreach ($rules as $key => $rule) {
            if (is_string($rule) && $rule === 'required') {
                unset($rules[$key]);
            }
        }

        return $rules;
    }

    public static function login()
    {
        return [
            'required',
            'string',
        ];
    }
}

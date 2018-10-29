<?php

namespace LangleyFoxall\LaravelNISTPasswordRules;

use LangleyFoxall\LaravelNISTPasswordRules\Rules\BreachedPasswords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\ContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DerivativesOfContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DictionaryWords;

abstract class PasswordRules
{
    public static function register($username)
    {
        return [
            'required',
            'string',
            'min:8',
            'confirmed',
            new DictionaryWords(),
            new ContextSpecificWords($username),
            new DerivativesOfContextSpecificWords($username),
            new BreachedPasswords(),
        ];
    }

    public static function changePassword($username, $oldPassword)
    {
        return [
            'required',
            'string',
            'min:8',
            'confirmed',
            'different:'.$oldPassword,
            new DictionaryWords(),
            new ContextSpecificWords($username),
            new DerivativesOfContextSpecificWords($username),
            new BreachedPasswords(),
        ];
    }

    public static function login()
    {
        return [
            'required',
            'string',
        ];
    }
}
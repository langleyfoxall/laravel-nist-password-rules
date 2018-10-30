<?php

namespace DivineOmega\PasswordExposed\Tests;

use Illuminate\Contracts\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use PHPUnit\Framework\TestCase;

class PasswordRulesTest extends TestCase
{
    public function passwordRulesProvider()
    {
        return [
            [PasswordRules::register('username')],
            [PasswordRules::changePassword('username', 'oldPassword')],
            [PasswordRules::login()],
        ];
    }

    /**
     * @dataProvider passwordRulesProvider
     */
    public function testRuleTypes($passwordRules)
    {
        foreach ($passwordRules as $rule) {
            $validType = is_string($rule) || (is_object($rule) && $rule instanceof Rule);
            $this->assertTrue($validType, 'Invalid rule type.');
        }
    }
}

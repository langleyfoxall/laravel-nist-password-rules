<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use Illuminate\Contracts\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use Orchestra\Testbench\TestCase;

class PasswordRulesTest extends TestCase
{
    private function getPasswordRuleSets()
    {
        return [
            PasswordRules::register('username'),
            PasswordRules::changePassword('username', 'oldPassword'),
            PasswordRules::changePassword('username'),
            PasswordRules::optionallyChangePassword('username', 'oldPassword'),
            PasswordRules::optionallyChangePassword('username'),
            PasswordRules::login(),
        ];
    }

    public function testRuleTypes()
    {
        $passwordRuleSets = $this->getPasswordRuleSets();

        foreach ($passwordRuleSets as $passwordRules) {
            foreach ($passwordRules as $rule) {
                $validType = is_string($rule) || (is_object($rule) && $rule instanceof Rule);
                $this->assertTrue($validType, 'Invalid rule type.');
            }
        }
    }
}

<?php

namespace DivineOmega\PasswordExposed\Tests;

use Illuminate\Contracts\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use PHPUnit\Framework\TestCase;

class PasswordRulesTest extends TestCase
{
    private function getPasswordRuleSets()
    {
        return [
            PasswordRules::register('username'),
            PasswordRules::changePassword('username', 'oldPassword'),
            PasswordRules::changePassword('username'),
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

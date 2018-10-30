<?php

namespace DivineOmega\PasswordExposed\Tests;

use Faker\Factory;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\BreachedPasswords;
use PHPUnit\Framework\TestCase;

class BreachedPasswordsTest extends TestCase
{
    public function exposedPasswordsProvider()
    {
        return [
            ['test'],
            ['password'],
            ['hunter2'],
        ];
    }

    /**
     * @dataProvider exposedPasswordsProvider
     */
    public function testFail($password)
    {
        $rule = (new BreachedPasswords());
        $this->assertFalse($rule->passes('password', $password));
    }

    public function testPass()
    {
        $password = $this->getPasswordUnlikelyToBeExposed();

        $rule = (new BreachedPasswords());
        $this->assertTrue($rule->passes('password', $password));
    }

    private function getPasswordUnlikelyToBeExposed()
    {
        $faker = Factory::create();
        $password = '';
        for ($i = 0; $i < 6; $i++) {
            $password .= $faker->word();
            $password .= ' ';
        }
        $password = trim($password);

        return $password;
    }
}

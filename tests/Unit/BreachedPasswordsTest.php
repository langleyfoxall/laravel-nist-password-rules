<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use Faker\Factory;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\BreachedPasswords;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;

class BreachedPasswordsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

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

    public function testMessage()
    {
        $rule = (new BreachedPasswords());
        $this->assertEquals('The :attribute was found in a third party data breach, and can not be used.', $rule->message());
    }
}

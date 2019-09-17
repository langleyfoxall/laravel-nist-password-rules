<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use LangleyFoxall\LaravelNISTPasswordRules\Rules\SequentialCharacters;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;

class SequentialCharactersTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function sequentialCharactersProvider()
    {
        return [
            ['123'],
            ['12345'],
            ['abcdef'],
            ['ghij'],
            ['321'],
        ];
    }

    public function nonSequentialCharactersProvider()
    {
        return [
            ['aa'],
            ['332211'],
            ['teeth'],
            ['passwordz'],
            ['cheese'],
            ['l337'],
        ];
    }

    /**
     * @dataProvider sequentialCharactersProvider
     */
    public function testFail($password)
    {
        $rule = (new SequentialCharacters());
        $this->assertFalse($rule->passes('password', $password));
    }

    /**
     * @dataProvider nonSequentialCharactersProvider
     */
    public function testPass($password)
    {
        $rule = (new SequentialCharacters());
        $this->assertTrue($rule->passes('password', $password));
    }

    public function testMessage()
    {
        $rule = (new SequentialCharacters());
        $this->assertEquals('The :attribute can not be sequential characters.', $rule->message());
    }
}

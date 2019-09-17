<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use LangleyFoxall\LaravelNISTPasswordRules\Rules\RepetitiveCharacters;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;

class RepetitiveCharactersTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function repetitiveCharactersProvider()
    {
        return [
            ['aaa'],
            ['1111'],
            ['aaaaaaaa'],
            ['eeeeee'],
            ['33333'],
        ];
    }

    public function nonRepetitiveCharactersProvider()
    {
        return [
            ['aaaaab'],
            ['112233'],
            ['teeth'],
            ['passwordz'],
            ['cheese'],
            ['l337'],
        ];
    }

    /**
     * @dataProvider repetitiveCharactersProvider
     */
    public function testFail($password)
    {
        $rule = (new RepetitiveCharacters());
        $this->assertFalse($rule->passes('password', $password));
    }

    /**
     * @dataProvider nonRepetitiveCharactersProvider
     */
    public function testPass($password)
    {
        $rule = (new RepetitiveCharacters());
        $this->assertTrue($rule->passes('password', $password));
    }

    public function testMessage()
    {
        $rule = (new RepetitiveCharacters());
        $this->assertEquals('The :attribute can not be repetitive characters.', $rule->message());
    }
}

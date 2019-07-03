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
            ['donkey123'],
            ['elephantabc'],
            ['davidcba'],
            ['what987'],
            ['yes!!!321'],
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
        $this->assertEquals('The :attribute can not have sequential characters of 3 or more.', $rule->message());
    }
}

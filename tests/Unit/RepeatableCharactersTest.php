<?php
namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use LangleyFoxall\LaravelNISTPasswordRules\Rules\RepeatableCharacters;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;


class RepeatableCharactersTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function repeatableCharactersProvider()
    {
        return [
            ['aaa'],
            ['1111'],
            ['aaa1111'],
            ['teeet'],
            ['l3337'],
        ];
    }

    public function nonRepeatableCharactersProvider()
    {
        return [
            ['aa'],
            ['112233'],
            ['teeth'],
            ['passwordz'],
            ['cheese'],
            ['l337'],
        ];
    }

    /**
     * @dataProvider repeatableCharactersProvider
     */
    public function testFail($password)
    {
        $rule = (new RepeatableCharacters());
        $this->assertFalse($rule->passes('password', $password));
    }

    /**
     * @dataProvider nonRepeatableCharactersProvider
     */
    public function testPass($password)
    {
        $rule = (new RepeatableCharacters());
        $this->assertTrue($rule->passes('password', $password));
    }


    public function testMessage()
    {
        $rule = (new RepeatableCharacters());
        $this->assertEquals('The :attribute can not have repeatable characters of 3 or more.', $rule->message());
    }
}

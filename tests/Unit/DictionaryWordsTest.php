<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use LangleyFoxall\LaravelNISTPasswordRules\Rules\DictionaryWords;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;

class DictionaryWordsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function dictionaryWordsProvider()
    {
        return [
            ['test'],
            ['password'],
            ['cat'],
            ['dog'],
            ['cheese'],
        ];
    }

    public function nonDictionaryWordsProvider()
    {
        return [
            ['test123'],
            ['passwordz'],
            ['c_a_t'],
            ['d0g'],
            ['ch33s3'],
        ];
    }

    /**
     * @dataProvider dictionaryWordsProvider
     */
    public function testFail($password)
    {
        $rule = (new DictionaryWords());
        $this->assertFalse($rule->passes('password', $password));
    }

    /**
     * @dataProvider nonDictionaryWordsProvider
     */
    public function testPass($password)
    {
        $rule = (new DictionaryWords());
        $this->assertTrue($rule->passes('password', $password));
    }

    public function testMessage()
    {
        $rule = (new DictionaryWords());
        $this->assertEquals('The :attribute can not be a dictionary word.', $rule->message());
    }
}

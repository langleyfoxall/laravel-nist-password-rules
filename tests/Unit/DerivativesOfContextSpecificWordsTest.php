<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use Faker\Factory;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DerivativesOfContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;

class DerivativesOfContextSpecificWordsTest extends TestCase
{
    private static $username;

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function contextSpecificWordsProvider()
    {
        if (!self::$username) {
            $faker = Factory::create();
            self::$username = $faker->userName;
        }

        return [
            [self::$username],
            [strtoupper(self::$username)],
            [substr(self::$username, 0, -2)],
            [strtoupper(substr(self::$username, 0, -2))],
            [substr(self::$username, 2)],
            [substr(self::$username, 1, -1)],
        ];
    }

    public function nonContextSpecificWordsProvider()
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
     * @dataProvider contextSpecificWordsProvider
     */
    public function testFail($password)
    {
        $rule = (new DerivativesOfContextSpecificWords(self::$username));
        $this->assertFalse($rule->passes('password', $password));
    }

    /**
     * @dataProvider nonContextSpecificWordsProvider
     */
    public function testPass($password)
    {
        $rule = (new DerivativesOfContextSpecificWords(self::$username));
        $this->assertTrue($rule->passes('password', $password));
    }

    public function testMessage()
    {
        $rule = (new DerivativesOfContextSpecificWords(self::$username));
        $this->assertEquals('The :attribute can not be similar to the word \'\'.', $rule->message());
    }
}

<?php

namespace LangleyFoxall\LaravelNISTPasswordRules\Tests\Unit;

use Faker\Factory;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\ContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider;
use Orchestra\Testbench\TestCase;

class ContextSpecificWordsTest extends TestCase
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
            ['123'.self::$username.'111'],
            ['123'.strtoupper(self::$username).'111'],
            ['cat'.self::$username],
            ['dog'.self::$username.'!!!'],
            ['che'.self::$username.'ese'],
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
        $rule = (new ContextSpecificWords(self::$username));
        $this->assertFalse($rule->passes('password', $password));
    }

    /**
     * @dataProvider nonContextSpecificWordsProvider
     */
    public function testPass($password)
    {
        $rule = (new ContextSpecificWords(self::$username));
        $this->assertTrue($rule->passes('password', $password));
    }

    public function testMessage()
    {
        $rule = (new ContextSpecificWords(self::$username));
        $this->assertEquals('The :attribute can not contain the word \'\'.', $rule->message());
    }

    public function testShortUsernamesAreExcluded()
    {
        $rule = (new ContextSpecificWords('ca'));
        $this->assertTrue($rule->passes('password', 'cat'));
    }
}

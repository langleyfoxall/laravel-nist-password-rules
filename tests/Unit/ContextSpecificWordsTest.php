<?php

namespace DivineOmega\PasswordExposed\Tests;

use Faker\Factory;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\ContextSpecificWords;
use PHPUnit\Framework\TestCase;

class ContextSpecificWordsTest extends TestCase
{
    private static $username;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if (!self::$username) {
            $faker = Factory::create();
            self::$username = $faker->userName;
        }
    }

    public function contextSpecificWordsProvider()
    {
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
}

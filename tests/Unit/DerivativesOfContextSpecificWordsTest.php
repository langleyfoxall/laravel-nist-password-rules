<?php

use Faker\Factory;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DerivativesOfContextSpecificWords;
use PHPUnit\Framework\TestCase;

class DerivativesOfContextSpecificWordsTest extends TestCase
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

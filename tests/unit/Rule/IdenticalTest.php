<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Identical;

/**
 * Class IdenticalTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class IdenticalTest extends Unit
{
    /**
     * @dataProvider identicalValidationData
     */
    public function testIdenticalValidation($token, $strict, $literal, $value, $expected)
    {
        $validator = new Identical($token, $strict, $literal);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function identicalValidationData()
    {
        return [
            0 => [
                '123', // Token
                true,  // Is strict
                true,  // Is literal
                '123', // Value to test
                true   // Expected result of validation
            ],
            1 => [
                '123',
                true,
                true,
                123,
                false
            ],
            2 => [
                '123',
                false,
                true,
                123,
                true
            ],
            3 => [
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true,
                true,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true
            ],
            4 => [
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                false,
                true,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true
            ],
            5 => [
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true,
                false,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true
            ],
            6 => [
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                false,
                true,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true
            ],
        ];
    }
}

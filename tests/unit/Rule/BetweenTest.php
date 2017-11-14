<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Between;

/**
 * Class BetweenTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class BetweenTest extends Unit
{
    /**
     * @dataProvider betweenValidationData
     */
    public function testBetweenValidation($valueMin, $valueMax, $inclusive, $value, $expected)
    {
        $validator = new Between($valueMin, $valueMax, $inclusive);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function betweenValidationData()
    {
        return [
            0 => [
                1,    // Value min
                2,    // Value max
                true, // Is inclusive
                1,    // Value to test
                true  // Expected result of validation
            ],
            1 => [
                1,
                2,
                true,
                2,
                true
            ],
            2 => [
                1,
                2,
                true,
                '1.1',
                true
            ],
            3 => [
                'a',
                'd',
                true,
                'c',
                true
            ],
            4 => [
                '1.2',
                '2.2',
                true,
                '1.21',
                true
            ],
            5 => [
                1,
                2,
                true,
                '2.1',
                false
            ],
            6 => [
                1,
                2,
                false,
                1,
                false
            ],
            7 => [
                'a',
                'd',
                true,
                'e',
                false
            ],
            8 => [
                '1.2',
                '2.2',
                true,
                '2.21',
                false
            ],
            9 => [
                0,
                PHP_INT_MAX,
                true,
                '999999',
                true
            ],
            10 => [
                0,
                PHP_INT_MAX,
                true,
                PHP_INT_MAX,
                true
            ],
            11 => [
                0,
                PHP_INT_MAX,
                false,
                PHP_INT_MAX,
                false
            ],
        ];
    }

    /**
     * @dataProvider betweenValidationDataWithoutParams
     */
    public function testBetweenValidationWithoutParams($value, $expected)
    {
        $validator = new Between();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function betweenValidationDataWithoutParams()
    {
        return [
            0 => [
                1,    // Value to test
                true  // Expected result of validation
            ],
            1 => [
                PHP_INT_MAX,
                true
            ]
        ];
    }
}

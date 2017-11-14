<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Digits;

/**
 * Class DigitsTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class DigitsTest extends Unit
{
    /**
     * @dataProvider digitsValidationData
     */
    public function testDigitsValidation($value, $expected)
    {
        $validator = new Digits();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function digitsValidationData()
    {
        return [
            0 => [
                '1234', // Value to test
                true    // Expected result of validation
            ],
            1 => [
                1234,
                true
            ],
            2 => [
                '1234a',
                false
            ]
        ];
    }
}

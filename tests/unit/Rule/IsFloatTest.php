<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\IsFloat;

/**
 * Class IsFloatTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class IsFloatTest extends Unit
{
    /**
     * @dataProvider isFloatValidationData
     */
    public function testIsFloatValidation($locale, $value, $expected)
    {
        $validator = new IsFloat($locale);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function isFloatValidationData()
    {
        return [
            0 => [
                'en',     // Locale
                '1234.5', // Value to test
                true      // Expected result of validation
            ],
            1 => [
                'en',
                '1,234.5',
                true
            ],
            2 => [
                'en',
                '1.234,5',
                false
            ],
            3 => [
                'de',
                '1234,5',
                true
            ],
            4 => [
                'de',
                '1.234,5',
                true
            ],
            5 => [
                'de',
                '1,234.5',
                false
            ]
        ];
    }
}

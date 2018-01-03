<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\IsInt;

/**
 * Class IsIntTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class IsIntTest extends Unit
{
    /**
     * @dataProvider isIntValidationData
     */
    public function testIsIntValidation($locale, $value, $expected)
    {
        $validator = new IsInt($locale);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function isIntValidationData()
    {
        return [
            0 => [
                'en',   // Locale
                '1234', // Value to test
                true    // Expected result of validation
            ],
            1 => [
                'en',
                '1,234',
                true
            ],
            2 => [
                'en',
                '1.234',
                false
            ],
            3 => [
                'de',
                '1234',
                true
            ],
            4 => [
                'de',
                '1.234',
                true
            ],
            5 => [
                'de',
                '1,234',
                false
            ]
        ];
    }
}

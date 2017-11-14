<?php
/**
 * Created by PhpStorm.
 * User: gde
 * Date: 10/08/2017
 * Time: 15:09
 */

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\StringLength;

/**
 * Class StringLengthTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class StringLengthTest extends Unit
{
    /**
     * @dataProvider stringLengthValidationData
     */
    public function testStringLengthValidation($lengthMin, $lengthMax, $value, $expected)
    {
        $validator = new StringLength($lengthMin, $lengthMax);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function stringLengthValidationData()
    {
        return [
            0 => [
                0,     // String length min
                15,    // String length max
                'abc', // Value to test
                true   // Expected result of validation
            ],
            1 => [
                0,
                15,
                'ABC',
                true
            ],
            2 => [
                0,
                15,
                'abc-def-ghi-jkl-',
                false
            ]
        ];
    }
}

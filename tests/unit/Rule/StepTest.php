<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Step;

/**
 * Class StepTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class StepTest extends Unit
{
    /**
     * @dataProvider stepValidationData
     */
    public function testStepValidation($baseValue, $step, $value, $expected)
    {
        $validator = new Step($baseValue, $step);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function stepValidationData()
    {
        return [
            0 => [
                1.1, // Base value
                2.2, // Step value
                1.1, // Value to test
                true // Expected result of validation
            ],
            1 => [
                1.1,
                2.2,
                3.3,
                true
            ],
            2 => [
                1.1,
                2.2,
                3.35,
                false
            ],
            3 => [
                1.1,
                2.2,
                3,
                false
            ],
        ];
    }

    /**
     * @dataProvider stepValidationDataWithoutParam
     */
    public function testStepValidationWithoutParam($value, $expected)
    {
        $validator = new Step();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function stepValidationDataWithoutParam()
    {
        return [
            0 => [
                1.1, // Value to test
                false // Expected result of validation
            ],
            1 => [
                3.3,
                false
            ],
            2 => [
                3.35,
                false
            ],
            3 => [
                3,
                true
            ],
            4 => [
                1,
                true
            ],
            5 => [
                0,
                true
            ]
        ];
    }
}

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
     * @dataProvider ipValidationData
     */
    public function testIpValidation($baseValue, $step, $value, $expected)
    {
        $validator = new Step($baseValue, $step);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function ipValidationData()
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
}

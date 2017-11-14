<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Callback;

/**
 * Class CallbackTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class CallbackTest extends Unit
{
    /**
     * @dataProvider callbackValidationData
     */
    public function testCallbackValidation($callable, $value, $expected)
    {
        $validator = new Callback($callable);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function callbackValidationData()
    {
        return [
            0 => [
                function ($value) {
                    if ($value === 1) {
                        return true;
                    }
                    return false;
                },   // Callable
                1,   // Value to test
                true // Expected result of validation
            ],
            1 => [
                function ($value) {
                    if ($value === 1) {
                        return true;
                    }
                    return false;
                },
                2,
                false
            ]
        ];
    }
}

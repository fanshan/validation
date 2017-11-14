<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Hex;

/**
 * Class HexTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class HexTest extends Unit
{
    /**
     * @dataProvider hexValidationData
     */
    public function testHexValidation($value, $expected)
    {
        $validator = new Hex();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function hexValidationData()
    {
        return [
            0 => [
                '000', // Value to test
                true   // Expected result of validation
            ],
            1 => [
                '000FFF',
                true
            ],
            2 => [
                'GGG',
                false
            ],
        ];
    }
}

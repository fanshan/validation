<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Iban;

/**
 * Class IbanTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class IbanTest extends Unit
{
    /**
     * @dataProvider ibanValidationData
     */
    public function testIbanValidation($countryCode, $value, $expected)
    {
        $validator = new Iban($countryCode);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function ibanValidationData()
    {
        return [
            0 => [
                'AT',                   // Country code
                'AT611904300234573201', // Value to test
                true                    // Expected result of validation
            ],
            1 => [
                'AT',
                'FR611904300234573201',
                false
            ]
        ];
    }
}

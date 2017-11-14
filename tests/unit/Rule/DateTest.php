<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Date;

/**
 * Class DateTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class DateTest extends Unit
{
    /**
     * @dataProvider dateValidationData
     */
    public function testDateValidation($format, $value, $expected)
    {
        $validator = new Date($format);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function dateValidationData()
    {
        return [
            0 => [
                'd/m/Y',      // Format
                '30/03/1990', // Value to test
                true          // Expected result of validation
            ],
            1 => [
                'd/m/Y',
                '03/30/1990',
                false
            ],
            2 => [
                'd-m-y',
                '30-03-90',
                true
            ],
            3 => [
                'd-m-y',
                '30-03-1990',
                false
            ],
            4 => [
                'd-m-y',
                '30/03/90',
                false
            ],
            5 => [
                'd.m.y H:i:s',
                '30.03.90 23:59:59',
                true
            ],
            6 => [
                'd.m.y H:i:s',
                '30.03.90 24:59:59',
                false
            ],
            7 => [
                'g:i a',
                '11:59 pm',
                true
            ],
            8 => [
                'D M j G:i:s T Y',
                'Sat Mar 20 17:00:00 MST 2017',
                true
            ]
        ];
    }
}

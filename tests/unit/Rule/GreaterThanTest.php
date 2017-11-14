<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\GreaterThan;

/**
 * Class GreaterThanTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class GreaterThanTest extends Unit
{
    /**
     * @dataProvider greaterThanValidationData
     */
    public function testGreaterThanValidation($minValue, $inclusive, $value, $expected)
    {
        $validator = new GreaterThan($minValue, $inclusive);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function greaterThanValidationData()
    {
        return [
            0 => [
                '3',   // Value min
                false, // Is inclusive
                '4',   // Value to test
                true   // Expected result of validation
            ],
            1 => [
                '3',
                true,
                '3',
                true
            ],
            2 => [
                '3',
                false,
                '3',
                false
            ],
            3 => [
                '3',
                false,
                '2',
                false
            ],
            4 => [
                '3',
                true,
                '2',
                false
            ],
            5 => [
                (new \DateTime('2017-01-02'))->format('Y-m-d'),
                true,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true
            ],
            6 => [
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                true
            ],
            7 => [
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                false,
                (new \DateTime('2017-01-03'))->format('Y-m-d'),
                false
            ],
        ];
    }

    /**
     * @dataProvider greaterThanValidationDataWithoutParams
     */
    public function testGreaterThanValidationWithoutParams($min, $value, $expected)
    {
        $validator = new GreaterThan($min);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function greaterThanValidationDataWithoutParams()
    {
        return [
            0 => [
                '3',
                '3',
                true
            ],
            1 => [
                '3',
                '4',
                true
            ],
            1 => [
                '3',
                '2',
                false
            ]
        ];
    }
}

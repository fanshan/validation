<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\LessThan;

/**
 * Class LessThanTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class LessThanTest extends Unit
{
    /**
     * @dataProvider lessThanValidationData
     */
    public function testLessThanValidation($maxValue, $inclusive, $value, $expected)
    {
        $validator = new LessThan($maxValue, $inclusive);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function lessThanValidationData()
    {
        return [
            0 => [
                '3',   // Value max
                false, // Is inclusive
                '2',   // Value to test
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
                '4',
                false
            ],
            4 => [
                '3',
                true,
                '4',
                false
            ],
            5 => [
                (new \DateTime('2017-01-02'))->format('Y-m-d'),
                true,
                (new \DateTime('2017-01-01'))->format('Y-m-d'),
                true
            ],
            6 => [
                (new \DateTime('2017-01-02'))->format('Y-m-d'),
                true,
                (new \DateTime('2017-01-02'))->format('Y-m-d'),
                true
            ],
            7 => [
                (new \DateTime('2017-01-02'))->format('Y-m-d'),
                false,
                (new \DateTime('2017-01-02'))->format('Y-m-d'),
                false
            ],
        ];
    }
}

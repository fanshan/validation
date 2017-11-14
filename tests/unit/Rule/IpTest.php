<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Ip;

/**
 * Class IpTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class IpTest extends Unit
{
    /**
     * @dataProvider ipValidationData
     */
    public function testIpValidation($allowIpv4, $allowIpv6, $allowIpvFuture, $allowLiteral, $value, $expected)
    {
        $validator = new Ip($allowIpv4, $allowIpv6, $allowIpvFuture, $allowLiteral);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function ipValidationData()
    {
        return [
            0 => [
                true,            // Allow IPV4
                false,           // Allow IPV6
                false,           // Allow IPV Future
                false,           // Allow literal
                '19.117.63.253', // Value to test
                true             // Expected result of validation
            ],
            1 => [
                true,
                false,
                false,
                true,
                '[19.117.63.253]',
                false
            ],
            2 => [
                false,
                true,
                false,
                false,
                '19.117.63.253',
                false
            ],
            3 => [
                false,
                true,
                false,
                false,
                '2001:db8:a0b:12f0::1',
                true
            ],
            4 => [
                false,
                true,
                false,
                true,
                '[2001:db8:a0b:12f0::1]',
                true
            ],
            5 => [
                false,
                true,
                false,
                false,
                '19.117.63.253',
                false
            ],
            6 => [
                false,
                false,
                true,
                false,
                'v1.fe80::a+en1',
                true
            ],
            7 => [
                false,
                false,
                true,
                true,
                '[v1.fe80::a+en1]',
                true
            ],
            8 => [
                false,
                false,
                true,
                false,
                '19.117.63.253',
                false
            ]
        ];
    }
}

<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\EmailAddress;
use Zend\Validator\Hostname;

/**
 * Class EmailAddressTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class EmailAddressTest extends Unit
{
    /**
     * @dataProvider emailAddressValidationData
     */
    public function testEmailAddressValidation($options, $value, $expected)
    {
        $validator = new EmailAddress($options);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function emailAddressValidationData()
    {
        return [
            0 => [
                [
                    'allow' => Hostname::ALLOW_DNS
                ],                // Options
                'test.test@gmail.com', // Value to test
                true              // Expected result of validation
            ],
            1 => [
                [],
                'test.test@gmail.com',
                true
            ],
            2 => [
                [
                    'allow' => Hostname::ALLOW_ALL
                ],
                'test.test@gmail.com',
                true
            ],
            3 => [
                [
                    'useMxCheck' => false
                ],
                'test.test@gmail.com',
                true
            ],
            4 => [
                [
                    'useMxCheck' => true
                ],
                'test.test@gmail.com',
                true
            ],
            5 => [
                [
                    'allow' => Hostname::ALLOW_IP
                ],
                'test.test@192.168.0.1',
                true
            ],
            6 => [
                [],
                'test.test@192.168.0.1',
                false
            ],
            7 => [
                [
                    'allow' => Hostname::ALLOW_ALL
                ],
                'test.test@192.168.0.1',
                true
            ],
            8 => [
                [
                    'allow' => Hostname::ALLOW_LOCAL
                ],
                'test.test@localhost',
                true
            ],
            9 => [
                [],
                'test.test@localhost',
                false
            ],
            10 => [
                [
                    'allow' => Hostname::ALLOW_ALL
                ],
                'test.test@localhost',
                true
            ],
            11 => [
                [],
                'test.test@localhost',
                false
            ],
        ];
    }
}

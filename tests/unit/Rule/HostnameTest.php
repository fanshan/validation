<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Hostname;

/**
 * Class HostnameTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class HostnameTest extends Unit
{
    /**
     * @dataProvider hostnameValidationData
     */
    public function testHostnameValidation($allow, $useIdnCheck, $useTldCheck, $ipValidator, $value, $expected)
    {
        $validator = new Hostname($allow, $useIdnCheck, $useTldCheck, $ipValidator);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function hostnameValidationData()
    {
        return [
            0 => [
                \Zend\Validator\Hostname::ALLOW_DNS, // Allow
                true,                                // Use IDN check
                true,                                // Use TLD check
                null,                                // IP validator
                'gmail.com',                         // Value to test
                true                                 // Expected result of validation
            ],
            1 => [
                \Zend\Validator\Hostname::ALLOW_IP,
                true,
                true,
                null,
                '192.168.0.1',
                true
            ],
            2 => [
                \Zend\Validator\Hostname::ALLOW_IP,
                true,
                true,
                null,
                '145',
                false
            ],
            3 => [
                \Zend\Validator\Hostname::ALLOW_LOCAL,
                true,
                true,
                null,
                'localhost',
                true
            ],
            4 => [
                \Zend\Validator\Hostname::ALLOW_LOCAL,
                true,
                true,
                null,
                '192.168.0.1',
                false
            ],
            5 => [
                \Zend\Validator\Hostname::ALLOW_ALL,
                true,
                true,
                null,
                '192.168.0.1',
                true
            ],
            6 => [
                \Zend\Validator\Hostname::ALLOW_ALL,
                true,
                true,
                null,
                'localhost',
                true
            ]
        ];
    }

    /**
     * @dataProvider hostnameValidationDataWithoutParams
     */
    public function testHostnameValidationWithoutParams($value, $expected)
    {
        $validator = new Hostname();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function hostnameValidationDataWithoutParams()
    {
        return [
            0 => [
                'gmail.com', // Value to test
                true         // Expected result of validation
            ],
            1 => [
                'localhost',
                true
            ],
            2 => [
                '192.168.0.1',
                true
            ]
        ];
    }
}

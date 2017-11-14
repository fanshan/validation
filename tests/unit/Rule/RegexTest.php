<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\Regex;

/**
 * Class RegexTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class RegexTest extends Unit
{
    /**
     * @dataProvider regexValidationData
     */
    public function testRegexValidation($pattern, $value, $expected)
    {
        $validator = new Regex($pattern);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function regexValidationData()
    {
        return [
            0 => [
                '/^\w+$/', // Pattern
                'test',    // Value to test
                true       // Expected result of validation
            ],
            1 => [
                '/^\w+$/',
                'test123',
                true
            ],
            2 => [
                '/^\w+$/',
                '*test123',
                false
            ],
            3 => [
                '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
                'test.test-test@gmail.com',
                true
            ],
            4 => [
                '/^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
                'test#test-test@gmail.',
                false
            ]
        ];
    }
}

<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\InArray;

/**
 * Class InArrayTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class InArrayTest extends Unit
{
    /**
     * @dataProvider inArrayValidationData
     */
    public function testInArrayValidation($haystack, $recursive, $strict, $value, $expected)
    {
        $validator = new InArray($haystack, $recursive, $strict);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function inArrayValidationData()
    {
        return [
            0 => [
                [
                    0 => 'value0',
                    1 => 'value1'
                ],                                                                                // Haystack
                false,                                                                            // Is recursive
                \Zend\Validator\InArray::COMPARE_NOT_STRICT_AND_PREVENT_STR_TO_INT_VULNERABILITY, // Comparison mode
                'value0',                                                                         // Value to test
                true                                                                              // Expected result of validation
            ],
            1 => [
                [
                    0 => 'value0',
                    1 => 'value1'
                ],
                false,
                \Zend\Validator\InArray::COMPARE_NOT_STRICT_AND_PREVENT_STR_TO_INT_VULNERABILITY,
                '0',
                false
            ],
            2 => [
                [
                    0 => 'value0',
                    1 => 'value1'
                ],
                false,
                \Zend\Validator\InArray::COMPARE_NOT_STRICT_AND_PREVENT_STR_TO_INT_VULNERABILITY,
                'value3',
                false
            ],
            3 => [
                [
                    0 => '0t',
                    1 => '1'
                ],
                false,
                \Zend\Validator\InArray::COMPARE_NOT_STRICT_AND_PREVENT_STR_TO_INT_VULNERABILITY,
                0,
                false
            ],
            4 => [
                [
                    0 => 'value0',
                    1 => 'value1',
                    2 => [
                        0 => 'value2-0',
                        1 => 'value2-1'
                    ]
                ],
                true,
                \Zend\Validator\InArray::COMPARE_NOT_STRICT_AND_PREVENT_STR_TO_INT_VULNERABILITY,
                'value2-0',
                true
            ],
            5 => [
                [
                    0 => '0t',
                    1 => '1'
                ],
                false,
                \Zend\Validator\InArray::COMPARE_NOT_STRICT,
                0,
                true
            ],
            6 => [
                [
                    0 => 'value0',
                    1 => 'value1',
                    2 => [
                        0 => '0t',
                        1 => 'value2-1'
                    ]
                ],
                true,
                \Zend\Validator\InArray::COMPARE_NOT_STRICT,
                0,
                true
            ],
            7 => [
                [
                    0 => '0t',
                    1 => '1'
                ],
                false,
                \Zend\Validator\InArray::COMPARE_STRICT,
                '0t',
                true
            ],
            8 => [
                [
                    0 => 'value0',
                    1 => 'value1',
                    2 => [
                        0 => '0t',
                        1 => 'value2-1'
                    ]
                ],
                true,
                \Zend\Validator\InArray::COMPARE_STRICT,
                '0t',
                true
            ],
            9 => [
                [
                    0 => '0t',
                    1 => '1'
                ],
                false,
                \Zend\Validator\InArray::COMPARE_STRICT,
                0,
                false
            ],
            10 => [
                [
                    0 => 'value0',
                    1 => 'value1',
                    2 => [
                        0 => '0t',
                        1 => 'value2-1'
                    ]
                ],
                true,
                \Zend\Validator\InArray::COMPARE_STRICT,
                0,
                false
            ],
        ];
    }
}

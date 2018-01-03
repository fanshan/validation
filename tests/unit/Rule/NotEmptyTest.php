<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\Validation\Rule\NotEmpty;

/**
 * Class NotEmptyTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class NotEmptyTest extends Unit
{
    /**
     * @dataProvider notEmptyValidationData
     */
    public function testNotEmptyValidation($types, $value, $expected)
    {
        $validator = new NotEmpty($types);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function notEmptyValidationData()
    {
        return [
            0 => [
                [
                    'boolean'
                ],
                true,
                true
            ],
            1 => [
                [
                    'boolean'
                ],
                false,
                false
            ],
            2 => [
                [
                    'integer'
                ],
                0,
                false
            ],
            3 => [
                [
                    'integer'
                ],
                1,
                true
            ],
            4 => [
                [
                    'float'
                ],
                0.0,
                false
            ],
            5 => [
                [
                    'integer'
                ],
                0.1,
                true
            ],
            6 => [
                [
                    'string'
                ],
                '',
                false
            ],
            7 => [
                [
                    'string'
                ],
                ' ',
                true
            ],
            8 => [
                [
                    'zero'
                ],
                '0',
                false
            ],
            9 => [
                [
                    'zero'
                ],
                '1',
                true
            ],
            10 => [
                [
                    'empty_array'
                ],
                [],
                false
            ],
            11 => [
                [
                    'empty_array'
                ],
                ['test'],
                true
            ],
            12 => [
                [
                    'null'
                ],
                null,
                false
            ],
            13 => [
                [
                    'null'
                ],
                'test',
                true
            ],
            14 => [
                [
                    'php'
                ],
                null,
                false
            ],
            15 => [
                [
                    'php'
                ],
                '',
                false
            ],
            16 => [
                [
                    'php'
                ],
                'test',
                true
            ],
            17 => [
                [
                    'space'
                ],
                ' ',
                false
            ],
            18 => [
                [
                    'space'
                ],
                '',
                true
            ],
            19 => [
                [
                    'object'
                ],
                new Collection([]),
                true
            ],
            20 => [
                [
                    'string',
                    'null',
                    'php'
                ],
                null,
                false
            ],
            21 => [
                [
                    'string',
                    'null',
                    'php'
                ],
                '',
                false
            ],
            22 => [
                [],
                '',
                false
            ],
            23 => [
                [],
                null,
                false
            ],
            24 => [
                [],
                new Collection([]),
                true
            ],
        ];
    }
}

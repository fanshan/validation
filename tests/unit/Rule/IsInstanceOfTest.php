<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use Codeception\Test\Unit;
use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\Validation\Rule\IsInstanceOf;

/**
 * Class IsInstanceOfTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class IsInstanceOfTest extends Unit
{
    /**
     * @dataProvider greaterThanValidationData
     */
    public function testGreaterThanValidation($className, $value, $expected)
    {
        $validator = new IsInstanceOf($className);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function greaterThanValidationData()
    {
        return [
            0 => [
                'ObjectivePHP\Primitives\Collection\Collection', // Class name
                new Collection([]),                              // Value to test
                true                                             // Expected result of validation
            ],
            1 => [
                Collection::class,
                new Collection([]),
                true
            ],
            2 => [
                'Collection',
                new Collection([]),
                false
            ],
        ];
    }
}

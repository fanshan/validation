<?php
/**
 * Created by PhpStorm.
 * User: gde
 * Date: 10/08/2017
 * Time: 15:09
 */

namespace Tests\ObjectivePHP\Validation\Rule;


use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\StringLength;

class StringLengthTest extends Unit
{

    public function testStringLengthValidation()
    {
        $validator = new StringLength(0, 15);

        $this->assertTrue($validator->validate('abc'));
        $this->assertFalse($validator->validate('abc-def-ghi-jkl-'));
    }
}
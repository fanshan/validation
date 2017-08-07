<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\EmailAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class ZendValidatorAdapterTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class ZendValidatorAdapterTest extends TestCase
{
    public function testValidationIsDone()
    {
        $adaptor = new EmailAddress();

        $this->assertTrue($adaptor->validate('test@test.com'));
    }

    public function testValidationWithErrorMessage()
    {
        $adapter = new EmailAddress();

        $this->assertFalse($adapter->validate('test'));
        $this->assertCount(1, $adapter->getNotifications());
        $this->assertEquals($adapter->getNotifications()->toArray(), $adapter->getValidator()->getMessages());
    }
}

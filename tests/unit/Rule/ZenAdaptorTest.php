<?php

namespace Tests\ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\ZendAdaptor;
use PHPUnit\Framework\TestCase;
use Zend\Validator\EmailAddress;

/**
 * Class ZenAdaptorTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule
 */
class ZenAdaptorTest extends TestCase
{
    public function testValidationIsDone()
    {
        $adaptor = new ZendAdaptor(new EmailAddress());

        $this->assertTrue($adaptor->validate('test@test.com'));
    }

    public function testValidationWithErrorMessage()
    {
        $adaptor = new ZendAdaptor(new EmailAddress());

        $this->assertFalse($adaptor->validate('test'));
        $this->assertCount(1, $adaptor->getNotifications());
        $this->assertEquals($adaptor->getNotifications()->toArray(), $adaptor->getValidator()->getMessages());
    }
}

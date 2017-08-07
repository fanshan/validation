<?php

namespace Tests\ObjectivePHP\Validation;

use ObjectivePHP\Notification\Stack;
use ObjectivePHP\Validation\Rule\AbstractValidationRule;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractValidationRuleTest
 *
 * @package Tests\ObjectivePHP\Validation
 */
class AbstractValidationRuleTest extends TestCase
{
    public function testNotificationsAccessors()
    {
        /** @var AbstractValidationRule $rule */
        $rule = $this->getMockForAbstractClass(AbstractValidationRule::class);

        $stack = new Stack();

        $rule->setNotifications($stack);

        $this->assertEquals($stack, $rule->getNotifications());
        $this->assertAttributeEquals($rule->getNotifications(), 'notifications', $rule);
    }
}

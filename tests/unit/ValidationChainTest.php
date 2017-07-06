<?php

namespace Tests {

    use ObjectivePHP\Notification\Alert;
    use ObjectivePHP\Validation\ValidationChain;
    use Tests\Helper\FailingRule;
    use Tests\Helper\PassingRule;

    class ValidationChainTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;

        // tests
        public function testChainValidation()
        {

            $chain = new ValidationChain();

            $chain->registerRule('key', new PassingRule());
            $chain->validate('');
            $this->assertCount(0, $chain->getNotifications());

            $alert = new Alert('this is way too short!');
            $chain->registerRule('other.key', new FailingRule(['length' => $alert]));

            $chain->validate('');

            $this->assertCount(1, $chain->getNotifications());
            $this->assertTrue($chain->getNotifications()->has('other.key'));
            $this->assertTrue($chain->getNotifications()->get('other.key')->has('length'));
            $this->assertSame($alert, $chain->getNotifications()->get('other.key')->get('length'));


        }

    }
}

namespace Tests\Helper {

    use ObjectivePHP\Validation\Rule\AbstractValidationRule;

    class PassingRule extends AbstractValidationRule
    {

        public function validate($data, $context = null): bool
        {
            return true;
        }

    }

    class FailingRule extends AbstractValidationRule
    {


        protected $failures = [];

        /**
         * FailingRule constructor.
         */
        public function __construct(array $messages)
        {
            $this->failures = $messages;
        }


        public function validate($data, $context = null): bool
        {
            foreach ($this->failures as $reference => $message) {
                $this->getNotifications()->set($reference, $message);
            }

            return false;
        }

    }
}

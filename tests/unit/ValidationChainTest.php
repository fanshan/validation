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

            $chain->registerRule(new PassingRule());
            $chain->validate('');
            $this->assertCount(0, $chain->getNotifications());

            $alert = new Alert('this is way too short!');
            $chain->registerRule(new FailingRule(['length' => $alert]));

            $chain->validate('');

            $this->assertCount(1, $chain->getNotifications());
            $this->assertTrue($chain->getNotifications()->has('length'));
            $this->assertSame($alert, $chain->getNotifications()->get('length'));
        }
    }
}

namespace Tests\Helper {

    use ObjectivePHP\Validation\Rule\AbstractValidationRule;

    class PassingRule extends AbstractValidationRule
    {

        public function validate($data, array $context = []): bool
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


        public function validate($data, array $context = []): bool
        {
            foreach ($this->failures as $reference => $message) {
                $this->getNotifications()->set($reference, $message);
            }

            return false;
        }

    }
}

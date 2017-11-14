<?php

namespace Tests {

    use ObjectivePHP\Notification\Alert;
    use ObjectivePHP\Validation\ValidationChain;
    use Tests\Helper\FailingRule;
    use Tests\Helper\PassingRule;

    /**
     * Class ValidationChainTest
     *
     * @package Tests
     */
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

    /**
     * Class PassingRule
     *
     * @package Tests\Helper
     */
    class PassingRule extends AbstractValidationRule
    {
        /**
         * @param mixed $data
         * @param null $context
         *
         * @return bool
         */
        public function validate($data, $context = null): bool
        {
            return true;
        }
    }

    /**
     * Class FailingRule
     *
     * @package Tests\Helper
     */
    class FailingRule extends AbstractValidationRule
    {
        protected $failures = [];

        /**
         * FailingRule constructor.
         *
         * @param array $messages
         */
        public function __construct(array $messages)
        {
            $this->failures = $messages;
        }

        /**
         * @param mixed $data
         * @param null $context
         *
         * @return bool
         */
        public function validate($data, $context = null): bool
        {
            foreach ($this->failures as $reference => $message) {
                $this->getNotifications()->set($reference, $message);
            }

            return false;
        }
    }
}

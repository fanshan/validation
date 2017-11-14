<?php

namespace Tests {

    use ObjectivePHP\Validation\Exception\ValidationException;
    use ObjectivePHP\Validation\HeapValidationChain;
    use Tests\Helper\HeapValidationRule;
    use Tests\Helper\OtherHeapValidationRule;

    /**
     * Class HeapValidationChainTest
     *
     * @package Tests
     */
    class HeapValidationChainTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;

        // tests
        public function testChainValidation()
        {
            $chain = new HeapValidationChain();

            $chain->registerRule('key', new HeapValidationRule());
            $chain->validate(['key' => 'valid']);
            $this->assertCount(0, $chain->getNotifications());

            $chain->validate(['key' => 'not valid']);
            $this->assertCount(1, $chain->getNotifications());
        }

        public function testChainValidationWithMultipleRules()
        {
            $chain = new HeapValidationChain();

            $chain->registerRule('key', new HeapValidationRule());
            $chain->registerRule('key', new OtherHeapValidationRule());
            $chain->validate(['key' => 'not valid']);
            $this->assertCount(2, $chain->getRules()->get('key'));
            $this->assertCount(2, $chain->getNotifications()->get('key'));
        }

        public function testHeapValidationChainOnlyAcceptsTraversableData()
        {
            $chain = new HeapValidationChain();
            $this->expectException(ValidationException::class);
            $chain->validate('scalar value');
        }
    }
}

namespace Tests\Helper {
    use ObjectivePHP\Notification\Alert;
    use ObjectivePHP\Validation\Rule\AbstractValidationRule;

    /**
     * Class HeapValidationRule
     *
     * @package Tests\Helper
     */
    class HeapValidationRule extends AbstractValidationRule
    {
        /**
         * @param mixed $data
         * @param null $context
         *
         * @return bool
         */
        public function validate($data, $context = null): bool
        {
            if ($data != 'valid') {
                $this->getNotifications()->addMessage('failed', new Alert('Data is not "valid"'));
            }

            return !$this->getNotifications()->hasError();
        }
    }

    /**
     * Class OtherHeapValidationRule
     *
     * @package Tests\Helper
     */
    class OtherHeapValidationRule extends AbstractValidationRule
    {
        /**
         * @param mixed $data
         * @param null $context
         *
         * @return bool
         */
        public function validate($data, $context = null): bool
        {
            if ($data != 'valid') {
                $this->getNotifications()->addMessage('failed.again', new Alert('Data is still not "valid"'));
            }
            return !$this->getNotifications()->hasError();
        }
    }
}

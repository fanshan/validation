<?php

namespace Tests {

    use ObjectivePHP\Validation\HeapValidationChain;
    use ObjectivePHP\Validation\ValidationException;
    use Tests\Helper\HeapValidationRule;
    use Tests\Helper\OtherHeapValidationRule;

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

    class HeapValidationRule extends AbstractValidationRule
    {
        public function validate($data, array $context = []) : bool
        {
            if ($data != 'valid') {
                $this->getNotifications()->addMessage('failed', new Alert('Data is not "valid"'));
            }

            return !$this->getNotifications()->hasError();
        }

    }

    class OtherHeapValidationRule extends AbstractValidationRule
    {
        public function validate($data, array $context = []) : bool
        {
            if ($data != 'valid') {
                $this->getNotifications()->addMessage('failed.again', new Alert('Data is still not "valid"'));
            }
            return !$this->getNotifications()->hasError();
        }

    }
}

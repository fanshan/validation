<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Notification\Stack;
use ObjectivePHP\Validation\Rule\AbstractValidationRule;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Class ValidationChain
 *
 * @package ObjectivePHP\Validation
 */
class HeapValidationChain extends AbstractValidationRule implements HeapValidationChainInterface
{
    public function validate($heap, array $context = []) : bool
    {
        if(!is_array($heap) && (!$heap instanceof \Iterator || !$heap instanceof \ArrayAccess)) {
            throw new ValidationException(__METHOD__ . ' expects data to be an array or ArrayObject like structure');
        }

        $isValid = true;

        /**
         * @var string $key
         * @var ValidationRuleInterface $rule
         */
        foreach ($this->getRules() as $key => $rule) {
            if (array_key_exists($key, $heap)) {
                $data = $heap[$key];
                if (!$rule->validate($data, $context)) {
                    if ($this->getNotifications()->lacks($key)) {
                        $this->getNotifications()->set($key, new Stack());
                    }

                    $this->getNotifications()->get($key)->merge($rule->getNotifications());

                    $isValid = false;
                }
            }
        }

        return $isValid;
    }

    /**
     * Register a validation rule
     *
     * @param string                  $key
     * @param ValidationRuleInterface $rule
     * @param array                   $context
     *
     * @return
     */
    public function registerRule(string $key, ValidationRuleInterface $rule, array $context = [])
    {
        // TODO: Implement registerRule() method.
    }

    /**
     * @return iterable
     */
    public function getRules()
    {
        // TODO: Implement getRules() method.
    }
}

<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Notification\Stack;
use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\Validation\Rule\AbstractValidationRule;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Class ValidationChain
 *
 * @package ObjectivePHP\Validation
 */
class HeapValidationChain extends AbstractValidationRule implements HeapValidationChainInterface
{
    /**
     * @var $this
     */
    protected $rules;

    /**
     * ValidationChain constructor.
     *
     * @param $rules
     */
    public function __construct($rules = null)
    {
        $this->rules = (new Collection);
    }

    public function validate($heap, array $context = []) : bool
    {
        if(!is_array($heap) && (!$heap instanceof \Iterator || !$heap instanceof \ArrayAccess)) {
            throw new ValidationException(__METHOD__ . ' expects data to be an array or ArrayObject like structure');
        }

        $isValid = true;

        /** @var Collection $rule */
        foreach ($this->getRules() as $key =>$rules) {
            /**
             * @var string $key
             * @var ValidationRuleInterface $rule
             */
            foreach ($rules as $rule) {
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
     * @return $this
     */
    public function registerRule(string $key, ValidationRuleInterface $rule, array $context = [])
    {
        if(!$this->rules->has($key)) {
            $this->rules->set($key, new Collection());
        }

        $this->rules->get($key)->append($rule);

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }
}

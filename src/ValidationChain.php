<?php

namespace ObjectivePHP\Validation;

use Countable;
use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\Validation\Rule\AbstractValidationRule;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Class ValidationChain
 *
 * @package ObjectivePHP\Validation
 */
class ValidationChain extends AbstractValidationRule implements ValidationChainInterface, Countable
{
    /**
     * @var Collection
     */
    protected $rules;

    /**
     * ValidationChain constructor.
     */
    public function __construct()
    {
        $this->rules = (new Collection);

        $this->init();
    }

    /**
     * Delegate constructor
     *
     * Use this method to register the chain rules
     */
    public function init()
    {
    }

    /**
     * @param $rules
     * @return $this
     */
    public function registerRules($rules)
    {
        $rules = Collection::cast($rules);

        foreach ($rules as $rule) {
            $this->registerRule($rule);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerRule(ValidationRuleInterface $rule)
    {
        $this->rules->append($rule);

        return $this;
    }

    /**
     * Get Rules
     *
     * @return Collection
     */
    public function getRules() : Collection
    {
        return $this->rules;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($data, $context = null): bool
    {
        $isValid = true;

        /** @var  $rule ValidationRuleInterface */
        foreach ($this->getRules() as $rule) {
            if (!$rule->validate($data, $context)) {
                $this->getNotifications()->add($rule->getNotifications()->getInternalValue());
                $isValid = false;
            }
        }

        return $isValid;
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     */
    public function count()
    {
        return count($this->rules);
    }
}

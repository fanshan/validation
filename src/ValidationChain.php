<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\ServicesFactory\ServicesFactory;
use ObjectivePHP\Validation\Rule\AbstractValidationRule;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Class ValidationChain
 *
 * @package ObjectivePHP\Validation
 */
class ValidationChain extends AbstractValidationRule implements ValidationChainInterface
{
    /**
     * @var
     */
    protected $servicesFactory;

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
     * @param ValidationRuleInterface $rule
     * @param array                   $context
     *
     * @return $this
     */
    public function registerRule(ValidationRuleInterface $rule, array $context = [])
    {
        $this->rules->append($rule);

        return $this;
    }

    /**
     * @param mixed $data
     * @param array $context
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate($data, array $context = []): bool
    {
        $isValid = true;

        /** @var  $rule ValidationRuleInterface */
        foreach ($this->getRules() as $rule) {
            if (!$rule->validate($data, $context)) {
                //if ($this->getNotifications()->lacks($key)) $this->getNotifications()->set($key, new Stack());
                $this->getNotifications()->add($rule->getNotifications()->getInternalValue());
                $isValid = false;
            }
        }

        return $isValid;
    }

    /**
     * @return bool
     */
    public function hasServicesFactory()
    {
        return !empty($this->servicesFactory);
    }

    /**
     * @return ServicesFactory
     */
    public function getServicesFactory(): ServicesFactory
    {
        return $this->servicesFactory;
    }

    /**
     * @param ServicesFactory $servicesFactory
     * @return $this
     */
    public function setServicesFactory(ServicesFactory $servicesFactory)
    {
        $this->servicesFactory = $servicesFactory;

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

}

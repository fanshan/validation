<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 04/07/2017
 * Time: 17:24
 */

namespace ObjectivePHP\Validation;


use ObjectivePHP\Notification\Stack;
use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\Primitives\Merger\MergePolicy;
use ObjectivePHP\Primitives\Merger\ValueMerger;
use ObjectivePHP\ServicesFactory\ServiceReference;
use ObjectivePHP\ServicesFactory\ServicesFactory;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Class ValidationChain
 * @package ObjectivePHP\Validation
 */
class ValidationChain implements ValidationChainInterface
{

    /**
     * @var
     */
    protected $servicesFactory;

    /**
     * @var Stack
     */
    protected $notifications;

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

        $this->notifications = new Stack();
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

        foreach ($rules as $key => $rule) {
            $this->registerRule($key, $rule);
        }

        return $this;
    }


    /**
     * @param $key
     * @param ValidationRuleInterface $rule
     * @return $this
     */
    public function registerRule($key, ValidationRuleInterface $rule)
    {

        if(!$this->rules->has($key)) {
            $this->rules->set($key, new Collection());
        }

        $this->rules->get($key)->append($rule);

        return $this;
    }


    /**
     * @param mixed $data
     * @return bool
     * @throws ValidationException
     */
    public function validate($data, $context = null): bool
    {

        $isValid = true;
        foreach ($this->rules as $key => $rules) {
            /** @var  $rule ValidationRuleInterface */
            foreach ($rules as $rule) {
                if ($this->hasServicesFactory()) {
                    if ($rule instanceof ServiceReference) {
                        $rule = $this->getServicesFactory()->get($rule);
                    } else {
                        $this->getServicesFactory()->injectDependencies($rule);
                    }
                } else {
                    if ($rule instanceof ServiceReference) {
                        throw new ValidationException('No ServicesFactory available to resolve reference to ' . $rule->getId());
                    }
                }

                if (!$rule->validate($data, $context)) {
                    if ($this->getNotifications()->lacks($key)) $this->getNotifications()->set($key, new Stack());
                    $this->getNotifications()->get($key)->add($rule->getNotifications()->getInternalValue());
                    $isValid = false;
                }
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

    /**
     * @return Stack
     */
    public function getNotifications(): Stack
    {
        return $this->notifications;
    }

    public function getRules()
    {
        return $this->rules;
    }

}

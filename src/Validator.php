<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 04/07/2017
 * Time: 17:24
 */

namespace ObjectivePHP\Validation\Validator;


use ObjectivePHP\Notification\Stack;
use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\ServicesFactory\ServiceReference;
use ObjectivePHP\ServicesFactory\ServicesFactory;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

class Validator implements ValidatorInterface
{
    
    protected $servicesFactory;
    
    protected $notifications;
    
    protected $rules = [];
    
    /**
     * Validator constructor.
     *
     * @param $rules
     */
    public function __construct($rules)
    {
        
        $this->notifications = new Stack();
        $rules               = Collection::cast($rules);
        
        $rules->each(function ($rule) {
            $this->registerRule($rule);
        });
        
        $this->init();
    }
    
    public function registerRule(ValidationRuleInterface ...$rules)
    {
        $this->rules += $rules;
        
        return $this;
    }
    
    public function init()
    {
    
    }
    
    public function validate($data): bool
    {
        $notifications = new Stack();
        
        $isValid = true;
        foreach ($this->rules as $rule) {
            if ($this->hasServicesFactory()) {
                if ($rule instanceof ServiceReference) {
                    $rule = $this->getServicesFactory()->get($rule);
                } else {
                    $this->getServicesFactory()->injectDependencies($rule);
                }
            } else {
                if($rule instanceof ServiceReference)
                {
                    throw new ValidatorException('No ServicesFactory available to resolve reference to ' . $rule->getId());
                }
            }
            
            if (!$rule->isValid($data, $notifications)) {
                $isValid = false;
            }
        }
        
        $this->notifications = $notifications;
        
        return $isValid;
    }
    
    public function hasServicesFactory()
    {
        return !empty($this->servicesFactory);
    }
    
    public function getServicesFactory(): ServicesFactory
    {
        return $this->servicesFactory;
    }
    
    public function setServicesFactory(ServicesFactory $servicesFactory)
    {
        $this->servicesFactory = $servicesFactory;
        
        return $this;
    }
    
    public function getNotifications(): Stack
    {
        return $this->notifications;
    }
    
}

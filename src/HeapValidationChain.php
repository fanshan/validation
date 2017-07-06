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
class HeapValidationChain extends ValidationChain
{

    /**
     * @param mixed $heap
     * @param null $context
     * @return bool
     */
    public function validate($heap, $context = null): bool
    {

        if(!is_array($heap) && (!$heap instanceof \Iterator || !$heap instanceof \ArrayAccess))
        {
            throw new ValidationException(__METHOD__ . ' expects data to be an array or ArrayObject like structure');
        }

        $isValid = true;
        foreach ($this->rules as $key => $rules) {

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

                if (array_key_exists($key, $heap)) {
                    $data = $heap[$key];
                    if (!$rule->validate($data, $heap)) {

                        if($this->getNotifications()->lacks($key)) $this->getNotifications()->set($key, new Stack());
                        $this->getNotifications()->get($key)->merge($rule->getNotifications());
                        $isValid = false;
                    }
                }
            }
        }

        return $isValid;
    }


}

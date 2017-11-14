<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Step
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Step extends ZendValidatorAdapter
{
    /**
     * Step constructor.
     *
     * @param int $baseValue
     * @param int $step
     */
    public function __construct($baseValue = 0, $step = 1)
    {
        $this->setValidator(new \Zend\Validator\Step(compact('baseValue', 'step')));
    }
}

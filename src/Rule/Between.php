<?php

namespace ObjectivePHP\Validation\Rule;


use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

class Between extends ZendValidatorAdapter
{


    /**
     * Between constructor.
     */
    public function __construct($min, $max, $inclusive = true)
    {
        $this->setValidator(new \Zend\Validator\Between(compact('min', 'max', 'inclusive')));
    }
}

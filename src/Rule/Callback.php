<?php

namespace ObjectivePHP\Validation\Rule;


use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

class Callback extends ZendValidatorAdapter
{


    /**
     * Between constructor.
     */
    public function __construct(callable $callback)
    {
        $this->setValidator(new \Zend\Validator\Callback(compact('callback')));
    }
}

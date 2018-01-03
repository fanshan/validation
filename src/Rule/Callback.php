<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Callback
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Callback extends ZendValidatorAdapter
{
    /**
     * Callback constructor.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->setValidator(new \Zend\Validator\Callback(compact('callback')));
    }
}

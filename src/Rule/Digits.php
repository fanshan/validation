<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Digits
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Digits extends ZendValidatorAdapter
{
    /**
     * Digits constructor.
     */
    public function __construct()
    {
        $this->setValidator(new \Zend\Validator\Digits());
    }
}

<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Hex
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Hex extends ZendValidatorAdapter
{
    /**
     * Hex constructor.
     */
    public function __construct()
    {
        $this->setValidator(new \Zend\Validator\Hex());
    }
}

<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class GreaterThan
 *
 * @package ObjectivePHP\Validation\Rule
 */
class GreaterThan extends ZendValidatorAdapter
{
    /**
     * GreaterThan constructor.
     *
     * @param $min
     * @param bool $inclusive
     */
    public function __construct($min, $inclusive = true)
    {
        $this->setValidator(new \Zend\Validator\GreaterThan(compact('min', 'inclusive')));
    }
}

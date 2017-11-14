<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Between
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Between extends ZendValidatorAdapter
{
    /**
     * Between constructor.
     *
     * @param int $min
     * @param int $max
     * @param bool $inclusive
     */
    public function __construct($min = 0, $max = PHP_INT_MAX, $inclusive = true)
    {
        $this->setValidator(new \Zend\Validator\Between(compact('min', 'max', 'inclusive')));
    }
}

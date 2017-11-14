<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class LessThan
 *
 * @package ObjectivePHP\Validation\Rule
 */
class LessThan extends ZendValidatorAdapter
{
    /**
     * LessThan constructor.
     *
     * @param $max
     * @param bool $inclusive
     */
    public function __construct($max, $inclusive = true)
    {
        $this->setValidator(new \Zend\Validator\LessThan(compact('max', 'inclusive')));
    }
}

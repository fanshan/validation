<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class IsInstanceOf
 *
 * @package ObjectivePHP\Validation\Rule
 */
class IsInstanceOf extends ZendValidatorAdapter
{
    /**
     * IsInstanceOf constructor.
     *
     * @param $className
     */
    public function __construct($className)
    {
        $this->setValidator(new \Zend\Validator\IsInstanceOf(compact('className')));
    }
}

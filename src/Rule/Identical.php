<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Identical
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Identical extends ZendValidatorAdapter
{
    /**
     * Identical constructor.
     *
     * @param $token
     * @param bool $strict
     * @param bool $literal
     */
    public function __construct($token, $strict = true, $literal = false)
    {
        $this->setValidator(new \Zend\Validator\Identical(compact('token', 'strict', 'literal')));
    }
}

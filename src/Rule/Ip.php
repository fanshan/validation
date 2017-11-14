<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Ip
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Ip extends ZendValidatorAdapter
{
    /**
     * Ip constructor.
     *
     * @param bool $allowipv4
     * @param bool $allowipv6
     * @param bool $allowipvfuture
     * @param bool $allowliteral
     */
    public function __construct($allowipv4 = true, $allowipv6 = true, $allowipvfuture = false, $allowliteral = true)
    {
        $this->setValidator(new \Zend\Validator\Ip(compact('allowipv4', 'allowipv6', 'allowipvfuture', 'allowliteral')));
    }
}

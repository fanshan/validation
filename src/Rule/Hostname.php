<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Hostname
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Hostname extends ZendValidatorAdapter
{
    /**
     * Hostname constructor.
     *
     * @param int $allow
     * @param bool $useIdnCheck
     * @param bool $useTldCheck
     * @param null $ipValidator
     */
    public function __construct($allow = \Zend\Validator\Hostname::ALLOW_ALL, $useIdnCheck = true, $useTldCheck = true, $ipValidator = null)
    {
        $this->setValidator(new \Zend\Validator\Hostname(compact('allow', 'useIdnCheck', 'useTldCheck', 'ipValidator')));
    }
}

<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class NotEmpty
 *
 * @package ObjectivePHP\Validation\Rule
 */
class NotEmpty extends ZendValidatorAdapter
{
    /**
     * NotEmpty constructor.
     *
     * @param $types
     */
    public function __construct($types = [])
    {
        $this->setValidator(new \Zend\Validator\NotEmpty($types));
    }
}

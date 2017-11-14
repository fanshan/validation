<?php

namespace ObjectivePHP\Validation\Rule\File;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Exists
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Exists extends ZendValidatorAdapter
{
    /**
     * FileExists constructor.
     *
     * @param array $directories
     */
    public function __construct($directories = [])
    {
        $this->setValidator(new \Zend\Validator\File\Exists($directories));
    }
}

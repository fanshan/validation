<?php

namespace ObjectivePHP\Validation\Rule\File;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Extension
 *
 * @package ObjectivePHP\Validation\Rule\File
 */
class Extension extends ZendValidatorAdapter
{
    /**
     * Extension constructor.
     *
     * @param array $extension
     * @param bool $case
     */
    public function __construct($extension = [], $case = false)
    {
        $this->setValidator(new \Zend\Validator\File\Extension(compact('extension', 'case')));
    }
}

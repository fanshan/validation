<?php

namespace ObjectivePHP\Validation\Rule\File;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class IsWritable
 *
 * @package ObjectivePHP\Validation\Rule\File
 */
class IsWritable extends ZendValidatorAdapter
{
    /**
     * IsWritable constructor.
     */
    public function __construct()
    {
        $this->setValidator(new \ObjectivePHP\Validation\Validator\IsWritable());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 07/08/2017
 * Time: 16:59
 */

namespace ObjectivePHP\Validation\Rule;


use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

class Regex extends ZendValidatorAdapter
{

    /**
     * Regex constructor.
     */
    public function __construct($pattern)
    {
        $this->setValidator(new \Zend\Validator\Regex($pattern));
    }
}

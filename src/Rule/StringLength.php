<?php
/**
 * Created by PhpStorm.
 * User: gde
 * Date: 10/08/2017
 * Time: 15:07
 */

namespace ObjectivePHP\Validation\Rule;


use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

class StringLength extends ZendValidatorAdapter
{
    public function __construct($min, $max, $encoding = 'UTF-8')
    {
        $this->setValidator(new \Zend\Validator\StringLength(compact('min', 'max', 'encoding')));
    }

}
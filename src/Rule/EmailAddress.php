<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 04/07/2017
 * Time: 17:43
 */

namespace ObjectivePHP\Validation\Rule;


use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;


class EmailAddress extends ZendValidatorAdapter
{

    public function __construct(array $options = [])
    {
        $this->setValidator(new \Zend\Validator\EmailAddress($options));
    }
}


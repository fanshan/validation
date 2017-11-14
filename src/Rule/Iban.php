<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class Iban
 *
 * @package ObjectivePHP\Validation\Rule
 */
class Iban extends ZendValidatorAdapter
{
    /**
     * Iban constructor.
     *
     * @param $countryCode
     */
    public function __construct($countryCode)
    {
        $this->setValidator(new \Zend\Validator\Iban(compact('countryCode')));
    }
}

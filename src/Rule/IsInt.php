<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class IsInt
 *
 * @package ObjectivePHP\Validation\Rule
 */
class IsInt extends ZendValidatorAdapter
{
    /**
     * IsInt constructor.
     *
     * @param null $locale
     */
    public function __construct($locale = null)
    {
        $this->setValidator(new \Zend\I18n\Validator\IsInt(compact('locale')));
    }
}

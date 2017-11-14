<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class IsFloat
 *
 * @package ObjectivePHP\Validation\Rule
 */
class IsFloat extends ZendValidatorAdapter
{
    /**
     * IsFloat constructor.
     *
     * @param null $locale
     */
    public function __construct($locale = null)
    {
        $this->setValidator(new \Zend\I18n\Validator\IsFloat(compact('locale')));
    }
}

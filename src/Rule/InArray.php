<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class InArray
 *
 * @package ObjectivePHP\Validation\Rule
 */
class InArray extends ZendValidatorAdapter
{
    /**
     * InArray constructor.
     *
     * @param $haystack
     * @param bool $recursive
     * @param int $strict
     */
    public function __construct(
        $haystack,
        $recursive = false,
        $strict = \Zend\Validator\InArray::COMPARE_NOT_STRICT_AND_PREVENT_STR_TO_INT_VULNERABILITY
    ) {
        $this->setValidator(new \Zend\Validator\InArray(compact('haystack', 'recursive', 'strict')));
    }
}

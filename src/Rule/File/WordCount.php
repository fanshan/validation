<?php

namespace ObjectivePHP\Validation\Rule\File;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class WordCount
 *
 * @package ObjectivePHP\Validation\Rule\File
 */
class WordCount extends ZendValidatorAdapter
{
    /**
     * WordCount constructor.
     *
     * @param null $min
     * @param null $max
     */
    public function __construct($min = null, $max = null)
    {
        $params = [
            'min' => (!is_null($min) ? $min : 0)
        ];

        if (!is_null($max)) {
            $params['max'] = $max;
        }

        $this->setValidator(new \Zend\Validator\File\WordCount($params));
    }
}

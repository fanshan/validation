<?php

namespace ObjectivePHP\Validation\Rule\File;

use ObjectivePHP\Validation\Rule\Adapter\ZendValidatorAdapter;

/**
 * Class FilesSize
 *
 * @package ObjectivePHP\Validation\Rule\File
 */
class FilesSize extends ZendValidatorAdapter
{
    /**
     * FilesSize constructor.
     *
     * @param null $min
     * @param null $max
     * @param bool $useByteString
     */
    public function __construct($min = null, $max = null, $useByteString = true)
    {
        $params = [
            'min' => (!is_null($min) ? $min : 0),
            'useByteString' => $useByteString
        ];

        if (!is_null($max)) {
            $params['max'] = $max;
        }

        $this->setValidator(new \Zend\Validator\File\FilesSize($params));
    }
}

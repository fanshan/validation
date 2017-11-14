<?php

namespace ObjectivePHP\Validation\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Validator which checks if a path is writable
 */
class IsWritable extends AbstractValidator
{
    /**
     * @const string Error constants
     */
    const DOES_NOT_EXIST  = 'pathDoesNotExist';
    const IS_NOT_WRITABLE = 'pathIsNotWritable';

    /**
     * @var array Error message templates
     */
    protected $messageTemplates = [
        self::DOES_NOT_EXIST  => "Path does not exist",
        self::IS_NOT_WRITABLE => "Path is not writable"
    ];

    /**
     * Returns true if and only if the path is writable
     *
     * @param  string $path Real path to check for writability
     *
     * @return bool
     */
    public function isValid($path)
    {
        if (!file_exists($path)) {
            $this->error(self::DOES_NOT_EXIST);
            return false;
        } else if (!is_writable($path)) {
            $this->error(self::IS_NOT_WRITABLE);
            return false;
        }

        return true;
    }
}

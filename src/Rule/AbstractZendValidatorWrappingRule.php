<?php

namespace ObjectivePHP\Validation\Rule;


use Iterator;
use ObjectivePHP\Notification\Alert;
use ObjectivePHP\Notification\MessageInterface;
use ObjectivePHP\Notification\Stack;
use ObjectivePHP\Validation\ValidationChainInterface;
use ObjectivePHP\Validation\ValidationException;
use Zend\Validator\ValidatorInterface;

/**
 * Class AbstractZendValidatorWrappingRule
 * @package ObjectivePHP\Validation\Rule
 */
abstract class AbstractZendValidatorWrappingRule extends AbstractValidationRule
{

    /**
     * @var ValidatorInterface Zend Validator class
     */
    static protected $validator;

    /**
     * @var
     */
    protected $validatorClass;

    /**
     * @var array
     */
    protected $validatorParameters = [];

    public function validate($data, $context = null): bool
    {
        $validator = $this->getValidator();

        if($validator->isValid($data)) {
            return true;
        } else {
            foreach($validator->getMessages() as $reference => $message)
            {
                $this->getNotifications()->set($reference, new Alert($message));
            }
            return false;
        }
    }


    /**
     * @return ValidatorInterface
     * @throws ValidationException
     */
    public function getValidator() : ValidatorInterface
    {
        if(is_null(self::$validator))
        {
            $className = $this->validatorClass;
            if(!class_exists($className))
            {
                throw new ValidationException('Required Zend Validator class "' . $className . '" is missing.');
            }
            self::$validator = new $className(...$this->validatorParameters);
        }

        return self::$validator;
    }

}

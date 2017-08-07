<?php

namespace ObjectivePHP\Validation\Rule\Adapter;

use ObjectivePHP\Notification\Alert;
use ObjectivePHP\Validation\Rule\AbstractValidationRule;
use ObjectivePHP\Validation\Rule\ValidationRuleInterface;
use Zend\Validator\ValidatorInterface;

/**
 * Class ZendValidatorAdapter
 *
 * @package ObjectivePHP\Validation\Rule
 */
class ZendValidatorAdapter extends AbstractValidationRule
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Get Validator
     *
     * @return ValidatorInterface
     */
    public function getValidator() : ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * Set Validator
     *
     * @param ValidatorInterface $validator
     *
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Tells if a data set complies to the validation rule
     *
     * @param mixed $data Data set to validate
     *
     * @return bool
     */
    public function validate($data, $context = null) : bool
    {
        if (!$this->getValidator()->isValid($data, $context)) {
            foreach ($this->getValidator()->getMessages() as $key => $message) {
                $this->getNotifications()->addMessage($key, new Alert($message));
            }

            return false;
        }

        return true;
    }
}

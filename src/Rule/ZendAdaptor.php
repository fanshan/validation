<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Notification\Alert;
use Zend\Validator\ValidatorInterface;

/**
 * Class ZendAdaptor
 *
 * @package ObjectivePHP\Validation\Rule
 */
class ZendAdaptor extends AbstractValidationRule implements ValidationRuleInterface
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * ZendAdaptor constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->setValidator($validator);
    }

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
    public function validate($data) : bool
    {
        if (!$this->getValidator()->isValid($data)) {
            foreach ($this->getValidator()->getMessages() as $key => $message) {
                $this->getNotifications()->addMessage($key, new Alert($message));
            }

            return false;
        }

        return true;
    }
}

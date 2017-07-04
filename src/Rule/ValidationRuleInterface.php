<?php

namespace ObjectivePHP\Validation\Rule;


use Iterator;
use ObjectivePHP\Notification\Stack;

interface ValidationRuleInterface
{
    /**
     * Tells if a data set complies to the validation rule
     *
     * @param Iterator|array $data Data set to validate
     *
     * @return bool
     */
    public function isValid($data, Stack $notifications) : bool;
}

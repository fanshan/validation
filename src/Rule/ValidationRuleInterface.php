<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Notification\Stack;

interface ValidationRuleInterface
{
    /**
     * Tells if a data set complies to the validation rule
     *
     * @param \Iterator|array $data Data set to validate
     * @param array           $context
     *
     * @return bool
     */
    public function validate($data, array $context = []) : bool;

    /**
     * @return Stack
     */
    public function getNotifications() : Stack;

}

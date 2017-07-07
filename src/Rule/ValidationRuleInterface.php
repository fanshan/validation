<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Notification\Stack;

/**
 * Interface ValidationRuleInterface
 *
 * @package ObjectivePHP\Validation\Rule
 */
interface ValidationRuleInterface
{
    /**
     * Tells if a data set complies to the validation rule
     *
     * @param mixed $data Data set to validate
     * @param array $context
     *
     * @return bool
     */
    public function validate($data, array $context = []) : bool;

    /**
     * @return Stack
     */
    public function getNotifications() : Stack;

}

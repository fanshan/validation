<?php

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Notification\Stack;

/**
 * Class AbstractValidationRule
 *
 * @package ObjectivePHP\Validation\Rule
 */
abstract class AbstractValidationRule implements ValidationRuleInterface
{
    /**
     * @var Stack
     */
    protected $notifications;

    /**
     * @return Stack
     */
    public function getNotifications() : Stack
    {
        if (is_null($this->notifications)) {
            $this->notifications = new Stack;
        }

        return $this->notifications;
    }

    /**
     * @param Stack $notifications
     *
     * @return $this
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }
}

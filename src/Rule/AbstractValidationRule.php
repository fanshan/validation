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
     * Get Notifications
     *
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
     * Set Notifications
     *
     * @param Stack $notifications
     *
     * @return $this
     */
    public function setNotifications(Stack $notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }
}

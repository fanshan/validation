<?php

namespace ObjectivePHP\Validation\Rule;


use ObjectivePHP\Notification\Stack;

abstract class AbstractValidationRule implements ValidationRuleInterface
{

    /**
     * @var Stack
     */
    protected $notifications;


    public function getNotifications(): Stack
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

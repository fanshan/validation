<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 04/07/2017
 * Time: 17:43
 */

namespace ObjectivePHP\Validation\Rule;

use ObjectivePHP\Notification\MessageInterface;
use ObjectivePHP\Notification\Stack;


class EmailAddress implements ValidationRuleInterface
{
    
    protected $property = 'email';
    
    const MISSING_AT_SYMBOL = 'validator.email.missing_at_symbol';
    
    /**
     * @var Stack
     */
    protected $notifications;
    
    /**
     * EmailAddress constructor.
     *
     * @param $property
     */
    public function __construct($property = null)
    {
        if($property) $this->property = $property;
    }
    
    
    public function validate($data, Stack $notifications = null): bool
    {
        if(is_null($notifications)) $notifications = new Stack();
        
        // direct validation
        if(!is_array($data) && !$data instanceof \Iterator)
        {
            $data = [$this->property => $data];
        }
        
        $email = $data[$this->property];
        
        // validate
        $delegate = new \Zend\Validator\EmailAddress;
        if(!$delegate->isValid($email)) {
            $notifications->set($this->property, new Stack());
            return false;
        }
        
        return true;
    }
    
    public function getNotifications(): Stack
    {
        return $this->notifications;
    }
    
    
}
$validator = new EmailAddress();
if(!$validator->validate('test@test'))
{
    $messages = $validator->getNotifications();
    
    $messages->each(function(MessageInterface $message) {
        echo $message;
    });
}

$user = [];
$validator = new EmailAddress('contact_email');
if (!$validator->validate($user)) {
    $messages = $validator->getNotifications();
    
    if($notifications->has(EmailAddress::MISSING_AT_SYMBOL))
    {
    
    }
    
    $messages->each(function (MessageInterface $message) {
        echo $message;
    });
}

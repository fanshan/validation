<?php

    namespace ObjectivePHP\Validation;

    use ObjectivePHP\Gateway\Entity\EntityInterface;
    use ObjectivePHP\Notification\Stack;
    use ObjectivePHP\ServicesFactory\ServicesFactory;
    use ObjectivePHP\Validation\Rule\ValidationRuleInterface;
    use Psr\Container\ContainerInterface;

    /**
     * Interface ValidationChainInterface
     *
     * @package ObjectivePHP\Gateway\Entity\ValidationChain
     */
    interface ValidationChainInterface
    {

        /**
         * @param mixed $data Data to be validated. Must be either an array or any iterable object
         *
         * @return bool
         */
        public function validate($data) : bool;

        /**
         * @return Stack
         */
        public function getNotifications() : Stack;
    
        /**
         * @param ValidationRuleInterface $rule
         * @param null                    $property
         *
         * @return mixed
         */
        public function registerRule($key, ValidationRuleInterface $rule);


        /**
         * @param $rules
         * @return mixed
         */
        public function registerRules($rules);
    
        /**
         * @param ServicesFactory $servicesFactory
         *
         * If you want to make use of an other container than ServicesFactory from ObjectivePHP, you still can
         * instantiate a ServicesFactory and register your own container implementing ContainerInterface in it:
         *
         * `$servicesFactory = (new ServicesFactory)->registerDelegateContainer($myContainer);`
         *
         * Doing this would allow to inject dependencies in your validation rules using the @Inject annotation
         * from the ServicesFactory package.
         *
         * @return $this
         */
        public function setServicesFactory(ServicesFactory $servicesFactory);
    
        /**
         * @return ServicesFactory
         */
        public function getServicesFactory() : ServicesFactory;

    }

<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 07/07/2017
 * Time: 17:40
 */
interface HeapValidationChainInterface extends ValidationRuleContainerInterface
{
    /**
     * Register a validation rule
     *
     * @param string                  $key
     * @param ValidationRuleInterface $rule
     * @param array                   $context
     *
     * @return
     */
    public function registerRule(string $key, ValidationRuleInterface $rule, array $context = []);
}

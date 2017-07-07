<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Interface ValidationChainInterface
 *
 * @package ObjectivePHP\Gateway\Entity\ValidationChain
 */
interface ValidationChainInterface extends ValidationRuleContainerInterface
{
    /**
     * Register a validation rule
     *
     * @param ValidationRuleInterface $rule
     * @param array                   $context
     */
    public function registerRule(ValidationRuleInterface $rule, array $context = []);
}

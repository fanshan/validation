<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Interface ValidationChainInterface
 *
 * @package ObjectivePHP\Gateway\Entity\ValidationChain
 */
interface ValidationChainInterface extends ValidationRuleInterface
{
    /**
     * Register a validation rule
     *
     * @param ValidationRuleInterface $rule
     */
    public function registerRule(ValidationRuleInterface $rule);
}

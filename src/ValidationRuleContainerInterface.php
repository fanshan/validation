<?php

namespace ObjectivePHP\Validation;

use ObjectivePHP\Validation\Rule\ValidationRuleInterface;

/**
 * Class RulesContainerInterface
 *
 * @package ObjectivePHP\Validation
 */
interface ValidationRuleContainerInterface extends ValidationRuleInterface
{
    /**
     * @return iterable
     */
    public function getRules();
}

<?php

namespace ObjectivePHP\Validation;

/**
 * Class RulesContainerInterface
 *
 * @package ObjectivePHP\Validation
 */
interface RulesContainerInterface
{
    /**
     * @return iterable
     */
    public function getRules();
}

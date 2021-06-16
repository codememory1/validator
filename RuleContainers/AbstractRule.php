<?php

namespace Codememory\Components\Validator\RuleContainers;

use Codememory\Components\Validator\Interfaces\RulesContainerInterface;

/**
 * Class AbstractRule
 *
 * @package Codememory\Components\Validator\RuleContainers
 *
 * @author  Codememory
 */
abstract class AbstractRule implements RulesContainerInterface
{

    /**
     * @return array
     */
    public function getRules(): array
    {

        return static::RULES;

    }

}
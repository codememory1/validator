<?php

namespace Codememory\Components\Validator\RuleContainers;

use Codememory\Components\Validator\Interfaces\RuleDataInterface;

/**
 * Class EnumRule
 *
 * @package Codememory\Components\Validator\RuleContainers
 *
 * @author  Codememory
 */
class EnumRule extends AbstractRule
{

    protected const RULES = [
        'only', 'not-only'
    ];

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function onlyRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return in_array($validatedValue, $ruleData->parameters()->getEnum());

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function notOnlyRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return !$this->onlyRule($ruleData, $validatedValue);

    }

}
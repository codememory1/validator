<?php

namespace Codememory\Components\Validator\RuleContainers;

use Codememory\Components\Validator\Interfaces\RuleDataInterface;

/**
 * Class ExpandingRule
 *
 * @package Codememory\Components\Validator\RuleContainers
 *
 * @author  Codememory
 */
class ExpandingRule extends AbstractRule
{

    public const RULES = [
        'not-empty', 'empty', 'custom'
    ];

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function notEmptyRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if (!empty($validatedValue)) {
            return call_user_func($this->getMethodNamespace($ruleData->parameters()->get()), $validatedValue);
        }

        return true;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function emptyRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if (empty($validatedValue)) {
            return call_user_func($this->getMethodNamespace($ruleData->parameters()->get()), $validatedValue);
        }

        return true;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function customRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return call_user_func($this->getMethodNamespace($ruleData->parameters()->get()), $validatedValue);

    }

}
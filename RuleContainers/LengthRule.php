<?php

namespace Codememory\Components\Validator\RuleContainers;

use Codememory\Components\Validator\Interfaces\RuleDataInterface;

/**
 * Class LengthRule
 *
 * @package Codememory\Components\Validator\RuleContainers
 *
 * @author  Codememory
 */
class LengthRule extends AbstractRule
{

    protected const RULES = [
        'min', 'max', 'range'
    ];

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function minRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if (mb_strlen($validatedValue) < (int) $ruleData->parameters()->get()) {
            return false;
        }

        return true;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function maxRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if (mb_strlen($validatedValue) > (int) $ruleData->parameters()->get()) {
            return false;
        }

        return true;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function rangeRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        $parameters = $ruleData->parameters();
        $min = $parameters->getMultiple()[0];
        $max = $parameters->getMultiple()[1];

        if (mb_strlen($validatedValue) < (int) $min || mb_strlen($validatedValue) > $max) {
            return false;
        }

        return true;

    }

}
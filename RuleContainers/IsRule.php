<?php

namespace Codememory\Components\Validator\RuleContainers;

use Codememory\Components\Validator\Interfaces\RuleDataInterface;

/**
 * Class IsRule
 *
 * @package Codememory\Components\Validator\RuleContainers
 *
 * @author  Codememory
 */
class IsRule extends AbstractRule
{

    protected const RULES = [
        'integer', 'float', 'number', 'string',
        'credible', 'alpha', 'alpha-num', 'alpha-dash',
        'array', 'boolean', 'email', 'required', 'regex',
        'rule', 'same'
    ];

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function integerRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return is_integer($validatedValue);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function floatRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return is_float($validatedValue) || is_double($validatedValue);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function numberRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return is_numeric($validatedValue);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function stringRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return is_string($validatedValue);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function credibleRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return in_array($validatedValue, ['on', 'yes', 1, true, 'ok']);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function alphaRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if(preg_match('/^[a-z]+$/i', $validatedValue)) {
            return true;
        }

        return false;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function alphaNumRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if(preg_match('/^[a-z0-9]+$/i', $validatedValue)) {
            return true;
        }

        return false;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function alphaDashRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        if(preg_match('/^[a-z0-9_-]+$/i', $validatedValue)) {
            return true;
        }

        return false;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function arrayRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return is_array($validatedValue);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function booleanRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return in_array($validatedValue, [1, 0, true, false]);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function emailRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return filter_var($validatedValue, FILTER_VALIDATE_EMAIL);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function requiredRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return !empty($validatedValue);

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function regexRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        $regex = sprintf('/%s/', $ruleData->parameters()->get());

        if(preg_match($regex, $validatedValue)) {
            return true;
        }

        return false;

    }

    /**
     * @param RuleDataInterface $ruleData
     * @param mixed             $validatedValue
     *
     * @return bool
     */
    public function sameRule(RuleDataInterface $ruleData, mixed $validatedValue): bool
    {

        return $validatedValue === $this->data[$ruleData->parameters()->get()];

    }

}
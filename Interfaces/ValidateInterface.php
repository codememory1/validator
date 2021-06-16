<?php

namespace Codememory\Components\Validator\Interfaces;

/**
 * Interface ValidateInterface
 *
 * @package Codememory\Components\Validator\Interfaces
 *
 * @author  Codememory
 */
interface ValidateInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add new rules to validation
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string      $rule  Rules and arguments
     * @param string|null $alias Alias rules by which you can add a message
     *
     * @return ValidateInterface
     */
    public function addRule(string $rule, ?string $alias = null): ValidateInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add an array array of rules to validation
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $rules
     *
     * @return ValidateInterface
     */
    public function addRules(array $rules): ValidateInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add a message to the rule that will be executed if the rule returns false
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string      $message
     * @param string|null $toAlias Add a message to a specific rule using its alias, by
     *                             default the identifier of the last added record is used
     *
     * @return ValidateInterface
     */
    public function addMessage(string $message, ?string $toAlias = null): ValidateInterface;

}
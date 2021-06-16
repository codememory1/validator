<?php

namespace Codememory\Components\Validator\Interfaces;

/**
 * Interface ValidatorInterface
 *
 * @package Codememory\Components\Validator\Interfaces
 *
 * @author  Codememory
 */
interface ValidatorInterface extends ValidationManagerInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add your own rules container that implements the RulesContainerInterface
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $rulesContainer
     *
     * @return ValidatorInterface
     */
    public function addRulesContainer(string $rulesContainer): ValidatorInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Create validation for a single data value
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string   $key      The name of the data key for which the validation is being generated
     * @param callable $callback Callback with an argument of type ValidateInterface
     *
     * @return ValidatorInterface
     */
    public function addValidation(string $key, callable $callback): ValidatorInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Make validation workout
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return ValidatorInterface
     */
    public function make(): ValidatorInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check the existence of a rule by its name
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return bool
     */
    public function existRule(string $name): bool;

}
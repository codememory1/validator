<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Validator\Exceptions\IncorrectRuleProcessingStateException;
use Codememory\Components\Validator\Exceptions\OverridingRulesException;
use Codememory\Components\Validator\Exceptions\RuleContainerInterfaceNotImplementedException;
use Codememory\Components\Validator\Exceptions\RuleDoesNotExistException;
use Codememory\Components\Validator\Interfaces\RuleInterface;
use Codememory\Components\Validator\Interfaces\RulesContainerInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;
use Codememory\Components\Validator\RuleContainers\IsRule;
use Codememory\Components\Validator\RuleContainers\LengthRule;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;

/**
 * Class Validator
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class Validator implements ValidatorInterface
{

    /**
     * @var array
     */
    private array $validatedData;

    /**
     * @var Utils
     */
    private Utils $utils;

    /**
     * @var array
     */
    private array $ruleContainers = [
        IsRule::class,
        LengthRule::class
    ];

    /**
     * @var array
     */
    private array $validations = [];

    /**
     * @var array
     */
    private array $errors = [];

    /**
     * Validator constructor.
     *
     * @param array $validatedData
     */
    public function __construct(array $validatedData)
    {

        $this->validatedData = $validatedData;
        $this->utils = new Utils();

    }

    /**
     * @inheritDoc
     *
     * @param string $rulesContainer
     *
     * @return ValidatorInterface
     * @throws RuleContainerInterfaceNotImplementedException
     * @throws ReflectionException
     * @throws OverridingRulesException
     */
    public function addRulesContainer(string $rulesContainer): ValidatorInterface
    {

        $reflector = new ReflectionClass($rulesContainer);
        $instance = $reflector->newInstance();
        $rules = [];
        $intersect = [];

        if (!$reflector->implementsInterface(RulesContainerInterface::class)) {
            throw new RuleContainerInterfaceNotImplementedException($rulesContainer, RulesContainerInterface::class);
        }

        foreach ($this->getAllRulesWithContainer() as $rulesWithContainer) {
            $rules = array_merge($rules, $rulesWithContainer['rules']);
        }

        $addedContainerRules = $reflector->getMethod('getRules')->invoke($instance);

        foreach ($rules as $rule) {
            if (in_array($rule, $addedContainerRules)) {
                $intersect[] = $rule;
            }
        }

        if ([] !== $intersect) {
            throw new OverridingRulesException(implode(',', $intersect));
        }

        $this->ruleContainers[] = $rulesContainer;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function addValidation(string $key, callable $callback): ValidatorInterface
    {

        $validate = new Validate();

        call_user_func($callback, $validate);
        
        $this->validations[$key] = $validate;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function make(): ValidatorInterface
    {

        $this->iterationValidations(function (string $dataKeyForValidation, Validate $validate) {
            /** @var RuleInterface $rule */
            foreach ($validate->getRules() as $rule) {
                $ruleData = $rule->data();
                $container = $this->getContainerByRuleName($ruleData->getRuleName());

                if (null === $container && $this->utils->checkExistRules()) {
                    throw new RuleDoesNotExistException($ruleData->getRuleName());
                }

                $ruleProcessingState = $this->callRuleMethod(
                    $container,
                    $ruleData->getRuleNameWithSuffix(),
                    $ruleData,
                    $this->validatedData[$dataKeyForValidation] ?? null
                );

                if (false === $ruleProcessingState) {
                    $this->errors[] = $rule->getMessage();
                }
            }
        });

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function isValidation(): bool
    {

        return [] === $this->errors;

    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {

        return $this->errors;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getError(): bool|string
    {

        if ([] === $this->getErrors()) {
            return false;
        }

        return $this->getErrors()[array_key_first($this->getErrors())];

    }

    /**
     * @inheritDoc
     */
    public function existRule(string $name): bool
    {

        return null !== $this->getContainerByRuleName($name);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of all rules and a container object for those rules
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    private function getAllRulesWithContainer(): array
    {

        $rulesWithContainer = [];

        foreach ($this->ruleContainers as $ruleContainer) {
            /** @var RulesContainerInterface $container */
            $container = new $ruleContainer($this->validatedData);

            $rules = $container->getRules();

            $rulesWithContainer[] = [
                'container' => $container,
                'rules'     => $rules
            ];
        }

        return $rulesWithContainer;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns a container object by rule name
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return RulesContainerInterface|null
     */
    private function getContainerByRuleName(string $name): ?RulesContainerInterface
    {

        foreach ($this->getAllRulesWithContainer() as $rulesWithContainer) {
            if (in_array($name, $rulesWithContainer['rules'])) {
                return $rulesWithContainer['container'];
            }
        }

        return null;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Iterate over all added validations and call the callback handler
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handler
     */
    private function iterationValidations(callable $handler): void
    {

        foreach ($this->validations as $dataKeyForValidation => $validate) {
            call_user_func($handler, $dataKeyForValidation, $validate);
        }

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Calling the rule handler method and returning its processing state, if
     * it does not return boolean, an exception will be thrown
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param RulesContainerInterface $rulesContainer
     * @param string                  $ruleName
     * @param mixed                   ...$args
     *
     * @return bool
     * @throws IncorrectRuleProcessingStateException
     */
    private function callRuleMethod(RulesContainerInterface $rulesContainer, string $ruleName, mixed ...$args): bool
    {

        $ruleProcessingState = $rulesContainer->$ruleName(...$args);

        if (!is_bool($ruleProcessingState)) {
            throw new IncorrectRuleProcessingStateException($ruleName);
        }

        return $ruleProcessingState;

    }

}
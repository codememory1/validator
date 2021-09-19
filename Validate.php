<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Validator\Interfaces\RuleInterface;
use Codememory\Components\Validator\Interfaces\ValidateInterface;

/**
 * Class Validate
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class Validate implements ValidateInterface
{

    /**
     * @var array
     */
    private array $rules = [];

    /**
     * @var string|int|null
     */
    private null|string|int $lastAddedKey = null;

    /**
     * @inheritDoc
     */
    public function addRule(string $rule, ?string $alias = null): ValidateInterface
    {

        if (null !== $alias) {
            $this->rules[$alias] = new Rule($rule);
        } else {
            $this->rules[] = new Rule($rule);
        }

        $this->lastAddedKey = array_key_last($this->rules);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function addRules(array $rules): ValidateInterface
    {

        foreach ($rules as $alias => $ruleName) {
            $this->addRule($ruleName, is_integer($alias) ? null : $alias);
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function addMessage(string $message, ?string $toAlias = null): ValidateInterface
    {

        if (null !== $toAlias) {
            /** @var RuleInterface $rule */
            $rule = &$this->rules[$toAlias];

            $rule->setMessage($message);
        } else {
            $this->rules[$this->lastAddedKey]->setMessage($message);
        }

        return $this;

    }

    /**
     * @return array
     */
    public function getRules(): array
    {

        return $this->rules;

    }

}
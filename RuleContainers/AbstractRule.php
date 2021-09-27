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
     * @var array
     */
    protected array $data;

    /**
     * @var string|null
     */
    protected ?string $namespaceValidation = null;

    /**
     * @param array $validatedData
     */
    public function __construct(array $validatedData = [])
    {

        $this->data = $validatedData;

    }

    /**
     * @inheritDoc
     */
    public function getRules(): array
    {

        return static::RULES;

    }

    /**
     * @inheritDoc
     */
    public function setNamespaceValidation(string $namespace): RulesContainerInterface
    {

        $this->namespaceValidation = $namespace;

        return $this;

    }

    /**
     * @param string $method
     *
     * @return string
     */
    protected function getMethodNamespace(string $method): string
    {

        return $this->namespaceValidation.'::'.$method;

    }

}
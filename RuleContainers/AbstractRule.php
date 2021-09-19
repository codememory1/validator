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
     * @param array $validatedData
     */
    public function __construct(array $validatedData = [])
    {

        $this->data = $validatedData;

    }

    /**
     * @return array
     */
    public function getRules(): array
    {

        return static::RULES;

    }

}
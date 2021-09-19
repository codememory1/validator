<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Validator\Interfaces\RuleDataInterface;
use Codememory\Components\Validator\Interfaces\RuleParametersInterface;
use Codememory\Support\Str;
use JetBrains\PhpStorm\Pure;

/**
 * Class RuleData
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class RuleData implements RuleDataInterface
{

    private const SUFFIX_RULE_NAME = 'Rule';
    private const NAME_SEPARATOR = ':';

    /**
     * @var string
     */
    private string $fullRuleString;

    /**
     * RuleData constructor.
     *
     * @param string $fullRuleString
     */
    public function __construct(string $fullRuleString)
    {

        $this->fullRuleString = $fullRuleString;

    }

    /**
     * @inheritDoc
     */
    public function getRuleName(): string
    {

        return explode(self::NAME_SEPARATOR, $this->fullRuleString)[0];

    }

    /**
     * @inheritDoc
     */
    public function getRuleNameWithSuffix(): string
    {

        return Str::camelCase($this->getRuleName()) . self::SUFFIX_RULE_NAME;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function parameters(): RuleParametersInterface
    {

        return new RuleParameters(explode(self::NAME_SEPARATOR, $this->fullRuleString, 2)[1] ?? null);

    }

}
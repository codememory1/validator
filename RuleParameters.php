<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Validator\Interfaces\RuleParametersInterface;
use Codememory\Support\Str;

/**
 * Class RuleParameters
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class RuleParameters implements RuleParametersInterface
{

    private const START_ENUM = '(';
    private const END_ENUM = ')';
    private const MULTIPLE_PARAMETER_SEPARATOR = ',';

    /**
     * @var string|null
     */
    private ?string $ruleParameters;

    /**
     * RuleParameters constructor.
     *
     * @param string|null $ruleParameters
     */
    public function __construct(?string $ruleParameters)
    {

        $this->ruleParameters = $ruleParameters;

    }

    /**
     * @inheritDoc
     */
    public function get(): ?string
    {

        return $this->ruleParameters;

    }

    /**
     * @inheritDoc
     */
    public function getMultiple(): array
    {

        $parameters = explode(self::MULTIPLE_PARAMETER_SEPARATOR, $this->get(), 2);
        $first = null;
        $last = null;

        if (!Str::starts($this->get(), self::START_ENUM) && !Str::ends($this->get(), self::END_ENUM)) {
            $first = $parameters[0] ?? null;
            $last = $parameters[1] ?? null;
        }

        return [$first, $last];

    }

    /**
     * @inheritDoc
     */
    public function getEnum(): array
    {

        if (Str::starts($this->get(), self::START_ENUM) && Str::ends($this->get(), self::END_ENUM)) {
            return explode(self::MULTIPLE_PARAMETER_SEPARATOR, $this->get());
        }

        return [];

    }

}
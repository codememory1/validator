<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Validator\Interfaces\RuleDataInterface;
use Codememory\Components\Validator\Interfaces\RuleInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class Rule
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class Rule implements RuleInterface
{

    /**
     * @var string
     */
    private string $fullRuleString;

    /**
     * @var ?string
     */
    private ?string $message = null;

    /**
     * Rule constructor.
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
    public function setMessage(string $message): RuleInterface
    {

        $this->message = $message;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function getMessage(): ?string
    {

        return $this->message;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function data(): RuleDataInterface
    {

        return new RuleData($this->fullRuleString);

    }

}
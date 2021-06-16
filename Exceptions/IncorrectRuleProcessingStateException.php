<?php

namespace Codememory\Components\Validator\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class IncorrectRuleProcessingStateException
 *
 * @package Codememory\Components\Validator\Exceptions
 *
 * @author  Codememory
 */
class IncorrectRuleProcessingStateException extends ValidatorException
{

    /**
     * IncorrectRuleProcessingStateException constructor.
     *
     * @param string $ruleName
     */
    #[Pure]
    public function __construct(string $ruleName)
    {

        parent::__construct(sprintf('The %s rules must return the correct state (bool)', $ruleName));

    }

}
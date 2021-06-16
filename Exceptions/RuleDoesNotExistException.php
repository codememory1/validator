<?php

namespace Codememory\Components\Validator\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class RuleDoesNotExistException
 *
 * @package Codememory\Components\Validator\Exceptions
 *
 * @author  Codememory
 */
class RuleDoesNotExistException extends ValidatorException
{

    /**
     * RuleDoesNotExistException constructor.
     *
     * @param string $name
     */
    #[Pure]
    public function __construct(string $name)
    {

        parent::__construct(sprintf('There is no "%s" rule for validation', $name));

    }

}
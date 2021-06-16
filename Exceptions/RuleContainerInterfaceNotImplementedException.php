<?php

namespace Codememory\Components\Validator\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class RuleContainerInterfaceNotImplementedException
 *
 * @package Codememory\Components\Validator\Exceptions
 *
 * @author  Codememory
 */
class RuleContainerInterfaceNotImplementedException extends ValidatorException
{

    /**
     * RuleContainerInterfaceNotImplementedException constructor.
     *
     * @param string $rulesContainer
     * @param string $interface
     */
    #[Pure]
    public function __construct(string $rulesContainer, string $interface)
    {

        parent::__construct(sprintf('The %s rules container must implement the %s interface', $rulesContainer, $interface));

    }

}
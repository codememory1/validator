<?php

namespace Codememory\Components\Validator\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class OverridingRulesException
 *
 * @package Codememory\Components\Validator\Exceptions
 *
 * @author  Codememory
 */
class OverridingRulesException extends ValidatorException
{

    /**
     * OverridingRulesException constructor.
     *
     * @param string $rules
     */
    #[Pure]
    public function __construct(string $rules)
    {

        parent::__construct(sprintf('Unable to override rules [%s] for validator', $rules));

    }

}
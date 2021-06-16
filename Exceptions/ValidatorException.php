<?php

namespace Codememory\Components\Validator\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class ValidatorException
 *
 * @package Codememory\Components\Validator\Exceptions
 *
 * @author  Codememory
 */
abstract class ValidatorException extends ErrorException
{

    /**
     * ValidatorException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    #[Pure]
    public function __construct(string $message = "", int $code = 0)
    {

        parent::__construct($message, $code);

    }

}
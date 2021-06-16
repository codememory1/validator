<?php

namespace Codememory\Components\Validator\Interfaces;

/**
 * Interface ValidationBuildInterface
 *
 * @package Codememory\Components\Validator\Interfaces
 *
 * @author  Codememory
 */
interface ValidationBuildInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The main method in which validations are generated
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ValidatorInterface $validator
     * @param                    ...$args
     *
     * @return void
     */
    public function build(ValidatorInterface $validator, ...$args): void;

}
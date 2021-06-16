<?php

namespace Codememory\Components\Validator\Interfaces;

/**
 * Interface RulesContainerInterface
 *
 * @package Codememory\Components\Validator\Interfaces
 *
 * @author  Codememory
 */
interface RulesContainerInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of container rules without a suffix
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function getRules(): array;

}
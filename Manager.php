<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;

/**
 * Class Manager
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class Manager
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Create a data validation manager
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ValidationBuildInterface $validationBuild Validation class
     * @param array                    $validatedData   Array of data to be checked using this validator
     * @param                          ...$args         Additionally, pass arguments to the method with the creation of validations
     *
     * @return ValidationManagerInterface
     */
    public function create(ValidationBuildInterface $validationBuild, array $validatedData, ...$args): ValidationManagerInterface
    {

        $validator = new Validator($validatedData);

        $validationBuild->build($validator, ...$args);

        return $validator->make();

    }

}
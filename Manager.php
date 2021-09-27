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
     * @var array
     */
    private array $argumentsFromBuild = [];

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Pass an argument to the validation build method
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function addArgument(string $name, mixed $value): Manager
    {

        $this->argumentsFromBuild[$name] = $value;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Create a data validation manager
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ValidationBuildInterface $validationBuild Validation class
     * @param array                    $validatedData   Array of data to be checked using this validator
     * @param mixed                    ...$args         Additionally, pass arguments to the method with the creation of
     *                                                  validations
     *
     * @return ValidationManagerInterface
     */
    public function create(ValidationBuildInterface $validationBuild, array $validatedData, mixed ...$args): ValidationManagerInterface
    {

        $validator = new Validator($validatedData);

        $validationBuild->build($validator, ...array_merge($args, $this->argumentsFromBuild));

        return $validator->make($validationBuild::class);

    }

}
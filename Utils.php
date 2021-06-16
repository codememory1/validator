<?php

namespace Codememory\Components\Validator;

use Codememory\Components\Configuration\Config;
use Codememory\Components\Configuration\Exceptions\ConfigNotFoundException;
use Codememory\Components\Configuration\Interfaces\ConfigInterface;
use Codememory\Components\Environment\Exceptions\EnvironmentVariableNotFoundException;
use Codememory\Components\Environment\Exceptions\IncorrectPathToEnviException;
use Codememory\Components\Environment\Exceptions\ParsingErrorException;
use Codememory\Components\Environment\Exceptions\VariableParsingErrorException;
use Codememory\Components\GlobalConfig\GlobalConfig;
use Codememory\FileSystem\File;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class Utils
 *
 * @package Codememory\Components\Validator
 *
 * @author  Codememory
 */
class Utils
{

    private ConfigInterface $config;

    /**
     * Utils constructor.
     *
     * @throws ConfigNotFoundException
     * @throws EnvironmentVariableNotFoundException
     * @throws IncorrectPathToEnviException
     * @throws ParsingErrorException
     * @throws VariableParsingErrorException
     */
    public function __construct()
    {

        $config = new Config(new File());

        $this->config = $config->open(GlobalConfig::get('validator.configName'), $this->getDefaultConfig());

    }

    /**
     * @return bool
     */
    public function checkExistRules(): bool
    {

        return (bool) $this->config->get('checkExistRules');

    }

    /**
     * @return string|null
     */
    public function getPathWithValidations(): ?string
    {

        return $this->config->get('pathWithValidations');

    }

    /**
     * @return string|null
     */
    public function getNamespaceWithValidations(): ?string
    {

        return $this->config->get('namespaceWithValidations');

    }

    /**
     * @return string|null
     */
    public function getSuffixClassName(): ?string
    {

        return $this->config->get('suffix');

    }

    /**
     * @return array
     */
    #[ArrayShape(['checkExistRules' => "mixed"])]
    public function getDefaultConfig(): array
    {

        return [
            'checkExistRules' => GlobalConfig::get('validator.checkExistRules')
        ];

    }

}
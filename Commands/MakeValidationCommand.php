<?php

namespace Codememory\Components\Validator\Commands;

use Codememory\Components\Console\Command;
use Codememory\Components\Validator\Utils;
use Codememory\Components\Validator\Utils as ValidationUtils;
use Codememory\Components\Validator\Validator;
use Codememory\FileSystem\File;
use Codememory\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MakeValidationCommand
 *
 * @package Codememory\Components\Validator\Commands
 *
 * @author  Codememory
 */
class MakeValidationCommand extends Command
{

    /**
     * @var string|null
     */
    protected ?string $command = 'make:validation';

    /**
     * @var string|null
     */
    protected ?string $description = 'Create validation';

    /**
     * @var string|null
     */
    private ?string $lastKeyForValidation = null;

    /**
     * @var array
     */
    private array $validations = [];

    /**
     * @var array
     */
    private array $rulesForValidation = [];

    /**
     * @return Command
     */
    protected function wrapArgsAndOptions(): Command
    {

        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Validation name')
            ->addOption('re-create', null, InputOption::VALUE_NONE, 'Re-create validation if it already exists');

        return $this;

    }

    /**
     * @inheritDoc
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        $filesystem = new File();
        $utils = new ValidationUtils();
        $name = $input->getArgument('name');
        $fullClassName = $name . $utils->getSuffixClassName();
        $fullPath = sprintf('%s/%s.php', trim($utils->getPathWithValidations(), '/'), $fullClassName);
        $stub = file_get_contents($filesystem->getRealPath('vendor/codememory/validator/Commands/Stubs/ValidationStub.stub'));

        if ($filesystem->exist($fullPath) && !$input->getOption('re-create')) {
            $this->io->error(sprintf('The %s validation already exists. If you want to recreate use the --re-create option', $fullClassName));

            return self::FAILURE;
        }

        $this->questions(new Validator());
        $this->getCodeSynthesis($utils, $fullClassName, $stub);

        file_put_contents($filesystem->getRealPath($fullPath), $stub);

        $this->io->success([
            sprintf('Validation %s succeeded', $fullClassName),
            sprintf('Path: %s', $fullPath)
        ]);

        return self::SUCCESS;

    }

    /**
     * @param ValidationUtils $utils
     * @param string          $fullClassName
     * @param string          $stub
     *
     * @return void
     */
    private function getCodeSynthesis(Utils $utils, string $fullClassName, string &$stub): void
    {

        $validations = null;

        foreach ($this->validations as $validation) {
            $rules = null;
            $messages = null;

            foreach ($validation['rules'] as $rule) {
                $messages .= $this->createMessage($rule['message'], $rule['alias']);
                $rules .= $this->createRule($rule['rule'], $rule['alias']);
            }

            $validations .= $this->createValidation($validation['dataKeyForValidation'], $rules . rtrim($messages, PHP_EOL) . ';') . "\n";
        }

        if (null !== $validations) {
            $validations = "\$validator\n" . rtrim($validations, PHP_EOL) . ';';
        }

        Str::replace($stub, [
            '{namespace}', '{className}', '{body}'
        ], [
            $utils->getNamespaceWithValidations(), $fullClassName, $validations
        ]);

    }

    /**
     * @param Validator $validator
     *
     * @return void
     */
    private function questions(Validator $validator): void
    {

        $addNewValidation = $this->io->confirm('Add new value validation?', true);

        if ($addNewValidation) {
            $this->io->ask('Specify the data key for which the validation is being created', null, function (mixed $value) use ($validator) {
                if (empty($value)) {
                    throw new RuntimeException('Key name must not be an empty string');
                }

                $this->lastKeyForValidation = $value;

                $this->questionRules($validator);

                $this->validations[] = [
                    'dataKeyForValidation' => $value,
                    'rules'                => $this->rulesForValidation
                ];
            });

            $this->rulesForValidation = [];

            $this->io->writeln(sprintf(' Validation %s added successfully', $this->tags->yellowText($this->lastKeyForValidation)));

            $this->questions($validator);
        }

    }

    /**
     * @param Validator $validator
     *
     * @return void
     */
    private function questionRules(Validator $validator): void
    {

        $ruleQuestion = sprintf('Specify the rules for the checked key %s', $this->tags->yellowText($this->lastKeyForValidation));

        $rule = $this->io->askWithAutocomplete($ruleQuestion, $validator->getRules(), null, function (mixed $rule) use ($validator) {
            if(!in_array($rule, $validator->getRules())) {
                throw new RuntimeException(sprintf('Rule %s does not exist', $rule));
            }

            return $rule;
        });

        if (null !== $rule) {
            $alias = $this->io->ask(sprintf('Specify an alias for the %s rule', $this->tags->yellowText($rule)), null, function (mixed $alias) {
                if (null === $alias) {
                    throw new RuntimeException('Rule alias cannot be empty');
                }

                return $alias;
            });
            $message = $this->io->ask(sprintf(
                'Specify messages for the %s rule with the %s alias, which will be triggered if the rule fails',
                $this->tags->yellowText($rule),
                $this->tags->yellowText($alias)
            ), null, function (mixed $message) {
                if (null === $message) {
                    throw new RuntimeException('The message cannot be empty');
                }

                return $message;
            });

            $this->rulesForValidation[] = [
                'rule'    => $rule,
                'alias'   => $alias,
                'message' => $message
            ];

            $this->io->writeln(sprintf(' Rule %s added successfully', $this->tags->yellowText($rule)));

            $this->questionRules($validator);
        }

    }

    /**
     * @param string      $rule
     * @param string|null $alias
     *
     * @return string
     */
    private function createRule(string $rule, ?string $alias): string
    {

        if (null !== $alias) {
            return sprintf("\t\t\t->addRule('%s', '%s')\n", $rule, $alias);
        }

        return sprintf("\t\t\t->addRule('%s')\n", $rule);

    }

    /**
     * @param string      $message
     * @param string|null $toAlias
     *
     * @return string
     */
    private function createMessage(string $message, ?string $toAlias): string
    {

        if (null !== $toAlias) {
            return sprintf("\t\t\t->addMessage('%s', '%s')\n", $message, $toAlias);
        }

        return sprintf("\t\t\t->addMessage('%s')\n", $message);

    }

    /**
     * @param string $dataKeyForValidation
     * @param string $validate
     *
     * @return string
     */
    private function createValidation(string $dataKeyForValidation, string $validate): string
    {

        $validation = <<<VALIDATION
                ->addValidation('%s', function(ValidateInterface \$validate) {
                    \$validate
            %s
                       
                    return \$validate;
                })
        VALIDATION;

        return sprintf($validation, $dataKeyForValidation, rtrim($validate, PHP_EOL));

    }

}
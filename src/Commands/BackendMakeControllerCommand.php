<?php

namespace Toyza55k\Backend\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;
use Toyza55k\Backend\Commands\ModelReplacements;

class BackendMakeControllerCommand extends GeneratorCommand
{
    use ModelReplacements;
    
    protected $name = 'make:backend-controller';

    protected $description = 'Create Backend Controller';

    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__.'/../stubs/backend/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\Backend';
    }

    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace, $this->option('model'));
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],
        ];
    }
}

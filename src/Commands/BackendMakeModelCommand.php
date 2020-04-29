<?php

namespace Toyza55k\Backend\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;
use Toyza55k\Backend\Commands\ModelReplacements;

class BackendMakeModelCommand extends GeneratorCommand
{
    use ModelReplacements;

    protected $name = 'make:backend-model';

    protected $description = 'Create a new Backend Eloquent model class';

    protected $type = 'Model';

    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }
        if ($this->option('all')) {
            $this->input->setOption('factory', true);
            $this->input->setOption('seed', true);
            $this->input->setOption('migration', true);
            $this->input->setOption('request', true);
            $this->input->setOption('controller', true);
            $this->input->setOption('view-model', true);
            $this->input->setOption('export', true);
        }

        if ($this->option('factory')) {
            $this->createFactory();
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('seed')) {
            $this->createSeeder();
        } 
        
        if ($this->option('request')) {
            $this->createRequest();
        }

        if ($this->option('view-model')) {
            $this->createViewModel();
        }

        if ($this->option('export')) {
            $this->createExport();
        }

        if ($this->option('controller')) {
            $this->createController();
        }
    }

    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    protected function createSeeder()
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $this->call('make:seed', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    protected function createRequest()
    {
        $request = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:backend-request', array_filter([
            'name'  => "{$request}Request",
            '--model' => $modelName,
        ]));
    }    

    protected function createExport()
    {
        $export = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:backend-export', array_filter([
            'name'  => "{$export}Export",
            '--model' => $modelName,
        ]));
    }

    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:backend-controller', array_filter([
            'name'  => "{$controller}Controller",
            '--model' => $modelName,
        ]));
    }

    protected function createViewModel()
    {
        $viewModel = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:backend-view', array_filter([
            'name'  => "{$viewModel}FormViewModel",
            '--model' => $modelName,
        ]));
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Model\Backend';
    }

    protected function buildClass($name)
    {
        $replace = $this->buildModelReplacements([], $name);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/../stubs/backend/model.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, and resource controller for the model'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['request', 'r', InputOption::VALUE_NONE, 'Create a new request for the model'],
            ['view-model', 'i', InputOption::VALUE_NONE, 'Create a new view-model for the model'],
            ['export', 'e', InputOption::VALUE_NONE, 'Create a new export for the model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['seed', 's', InputOption::VALUE_NONE, 'Create a new seeder file for the model'],
            ['pivot', 'p', InputOption::VALUE_NONE, 'Create a new seeder file for the model'],
        ];
    }
}

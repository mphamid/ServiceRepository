<?php

namespace vandarpay\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:service-repository')]
class ServiceRepositoryMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service-repository';

    protected $description = 'Create a new repository class';

    protected $type = 'Service Repository';

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Repository.php';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/service-repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\Services\\" . Str::studly($this->argument('name'));
    }

}

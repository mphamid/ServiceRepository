<?php

namespace vandarpay\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:service-exception')]
class ServiceExceptionMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service-exception';

    protected $description = 'Create a new service exception class';

    protected $type = 'Service Exception';

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Exception.php';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/service-exception.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\Services\\" . Str::studly($this->argument('name'));
    }

}

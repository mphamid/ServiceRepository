<?php

namespace mphamid\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:service-transformer')]
class ServiceTransformerMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service-transformer';

    protected $description = 'Create a new service transformer class';

    protected $type = 'Service Transformer';

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Transformer.php';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/service-transformer.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\Services\\" . Str::studly($this->argument('name'));
    }

}

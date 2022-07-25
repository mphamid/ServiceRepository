<?php

namespace vandarpay\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:dto')]
class DtoMakeCommand extends GeneratorCommand
{
    protected $name = 'make:dto';

    protected $description = 'Create a new dto class';

    protected $type = 'Dto';

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Dto.php';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/dto.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\DTO" ;
    }

}

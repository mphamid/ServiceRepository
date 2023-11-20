<?php

namespace mphamid\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

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
        if($this->option('grpc')){
            return __DIR__ . '/stubs/service-repository-grpc.stub';
        }
        return __DIR__ . '/stubs/service-repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\Services\\" . Str::studly($this->argument('name'));
    }
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['grpc', 'g', InputOption::VALUE_NONE, 'Generate service for grpc server.']
        ];
    }
}

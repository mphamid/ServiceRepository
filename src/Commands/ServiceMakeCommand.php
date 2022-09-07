<?php

namespace vandarpay\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:service')]
class ServiceMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service';

    protected $description = 'Create a new service repository class';

    protected $type = 'Service';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createException();
        $this->createRepository();
        if ($this->option('transformer')) {
            $this->createTransformer();
        }
        if ($this->option('language')) {
            $this->buildLanguageFile();
        }
        parent::handle();
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', Str::studly($name));
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Service.php';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\Services\\" . Str::studly($this->argument('name'));
    }

    private function createException()
    {

        $this->call('make:service-exception', [
            'name' => "{$this->argument('name')}",
        ]);
    }

    private function createRepository()
    {
        $grpc = $this->option('grpc');

        $this->call('make:service-repository', [
            'name' => "{$this->argument('name')}",
            '--grpc' => "{$grpc}",
        ]);
    }

    private function createTransformer()
    {
        $this->call('make:service-transformer', [
            'name' => "{$this->argument('name')}",
        ]);
    }

    private function buildLanguageFile()
    {
        $language = $this->option('language');

        $this->call('make:service-exception-language', [
            'name' => "{$this->argument('name')}",
            '--language' => "{$language}",
        ]);

    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['language', 'l', InputOption::VALUE_OPTIONAL, 'Generate a language file for service exception.'],
            ['transformer', 't', InputOption::VALUE_NONE, 'Generate service transformer for rpc.'],
            ['grpc', 'g', InputOption::VALUE_NONE, 'Generate service for grpc server.'],
        ];
    }

}

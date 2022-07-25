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

    protected $description = 'Create a new custom Ignition solution class';

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
        $this->createTransformer();
        if ($this->option('language')) {
            $this->buildLanguageFile();
        }
        parent::handle();
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
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
        $exception = Str::studly($this->argument('name'));

        $this->call('make:service-exception', [
            'name' => "{$exception}",
        ]);
    }

    private function createRepository()
    {
        $repository = Str::studly($this->argument('name'));

        $this->call('make:service-repository', [
            'name' => "{$repository}",
        ]);
    }

    private function createTransformer()
    {
        $transformer = Str::studly($this->argument('name'));

        $this->call('make:service-transformer', [
            'name' => "{$transformer}",
        ]);
    }

    private function buildLanguageFile()
    {
        $language = $this->option('language');
        $name = Str::studly($this->argument('name'));

        $this->call('make:service-exception-language', [
            'name' => "{$name}",
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
        ];
    }

}

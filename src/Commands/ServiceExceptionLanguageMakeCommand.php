<?php

namespace vandarpay\ServiceRepository\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:service-exception-language')]
class ServiceExceptionLanguageMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service-exception-language';

    protected $description = 'Create a new service exception language file';

    protected $type = 'Service Exception Language';

    protected function getPath($name)
    {
        $name = Str::studly($this->argument('name'));
        $languageFile = $this->option('language');
        if (empty($languageFile)) {
            $languageFile = App::getLocale();
        }
        return lang_path($languageFile . '/exceptions/' . str_replace('\\', '/', strtolower($name)) . '_exception.php');
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/exception.stub';
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
            ['language', 'l', InputOption::VALUE_REQUIRED, 'Generate a language file for service exception.'],
        ];
    }
}

<?php

namespace vandarpay\ServiceRepository;

use Illuminate\Support\ServiceProvider;
use vandarpay\ServiceRepository\Commands\DtoMakeCommand;
use vandarpay\ServiceRepository\Commands\ServiceExceptionLanguageMakeCommand;
use vandarpay\ServiceRepository\Commands\ServiceExceptionMakeCommand;
use vandarpay\ServiceRepository\Commands\ServiceMakeCommand;
use vandarpay\ServiceRepository\Commands\ServiceRepositoryMakeCommand;
use vandarpay\ServiceRepository\Commands\ServiceTransformerMakeCommand;

class ServiceRepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    protected function registerCommands(): void
    {
        $this->commands([
            ServiceExceptionMakeCommand::class,
            ServiceRepositoryMakeCommand::class,
            ServiceTransformerMakeCommand::class,
            ServiceExceptionLanguageMakeCommand::class,
            ServiceMakeCommand::class,
            DtoMakeCommand::class,
        ]);
    }

}

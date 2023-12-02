<?php

namespace mphamid\ServiceRepository;

use Illuminate\Support\ServiceProvider;
use mphamid\ServiceRepository\Commands\DtoMakeCommand;
use mphamid\ServiceRepository\Commands\ServiceExceptionLanguageMakeCommand;
use mphamid\ServiceRepository\Commands\ServiceExceptionMakeCommand;
use mphamid\ServiceRepository\Commands\ServiceMakeCommand;
use mphamid\ServiceRepository\Commands\ServiceRepositoryMakeCommand;
use mphamid\ServiceRepository\Commands\ServiceTransformerMakeCommand;

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

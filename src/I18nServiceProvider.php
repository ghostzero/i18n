<?php

namespace GhostZero\I18n;

use GhostZero\I18n\Services\ServiceManager;
use Illuminate\Support\ServiceProvider;
use GhostZero\I18n\Services\SimpleLocalize\SimpleLocalize;

class I18nServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->configure();
        $this->app->singleton(ServiceManager::class);

        $this->registerCommands();
        $this->registerServices();
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\DownloadCommand::class,
                Commands\UploadCommand::class,
            ]);
        }
    }

    private function registerServices()
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = app(ServiceManager::class);

        $serviceManager->extend('simplelocalize', function () {
           return new SimpleLocalize();
        });
    }

    private function configure()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/i18n.php', 'i18n');
    }
}
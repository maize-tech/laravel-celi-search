<?php

namespace Maize\CeliSearch;

use Laravel\Scout\Builder;
use Laravel\Scout\EngineManager;
use Laravel\Scout\ScoutServiceProvider;
use Maize\CeliSearch\Commands\ReImportCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CeliSearchServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-celi-search')
            ->hasConfigFile()
            ->hasCommand(ReImportCommand::class);
    }

    public function registeringPackage()
    {
        $this->app->register(ScoutServiceProvider::class);
    }

    public function packageBooted()
    {
        resolve(EngineManager::class)->extend('celi-search', function () {
            return new CeliSearchEngine();
        });

        collect($this->macros())
            ->reject(fn ($class, $macro) => Builder::hasMacro($macro))
            ->each(fn ($class, $macro) => Builder::macro($macro, app($class)()));
    }

    private function macros(): array
    {
        return [
            'withHighlight' => \Maize\CeliSearch\Macros\WithHighlight::class,
            'withDefType' => \Maize\CeliSearch\Macros\WithDefType::class,
            'withMinimumShouldMatch' => \Maize\CeliSearch\Macros\WithMinimumShouldMatch::class,
        ];
    }
}

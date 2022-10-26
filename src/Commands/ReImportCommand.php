<?php

namespace Maize\CeliSearch\Commands;

use Illuminate\Console\Command;
use Maize\CeliSearch\CeliSearch;
use Maize\CeliSearch\Searchable;
use Maize\CeliSearch\Support\Config;

class ReImportCommand extends Command
{
    public $signature = 'celi-search:reimport
            {model? : Class name of model to reimport}
            {--c|chunk= : The number of records to import at a time (Defaults to configuration value: `scout.chunk.searchable`)}';

    public $description = 'Reimport the given models into the search index';

    public function handle(): void
    {
        $searchables = Config::getSearchables(
            $this->argument('model')
        );

        if ($searchables->isEmpty()) {
            return;
        }

        $this->info("Importing [{$searchables->implode(',')}] records.");
        $this->newLine();

        $this->initializeVersion();

        $this->withProgressBar($searchables, function (string $class) {
            $model = new $class();

            $method = $model instanceof Searchable
                ? 'searchable'
                : 'makeAllSearchable';

            $model->$method(
                $this->option('chunk')
            );
        });

        $this->finalizeVersion();

        $this->newLine();
        $this->getOutput()->success("All [{$searchables->implode(',')}] records have been imported.");
    }

    protected function initializeVersion(): string
    {
        /** @var string */
        $version = CeliSearch::initialize()->get('version');

        Config::setVersion($version);

        return $version;
    }

    protected function finalizeVersion(): void
    {
        $version = Config::getVersion();

        CeliSearch::finalize($version);

        Config::clearVersion();
    }
}

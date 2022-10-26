<?php

namespace Maize\CeliSearch\Tests\Support;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maize\CeliSearch\CeliSearchServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Maize\\CeliSearch\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CeliSearchServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('scout.driver', 'celi-search');
        config()->set('celi-search.base_url', 'http://celi.test');
        config()->set('celi-search.search_base_url', 'http://celi-search.test');
        config()->set('celi-search.project', 'test');

        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
}

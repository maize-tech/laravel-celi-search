<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Testing\PendingCommand;
use Maize\CeliSearch\Tests\Support\TestCase;

uses(TestCase::class)->in(__DIR__);

function artisan(string $command, array $parameters = []): PendingCommand|int
{
    return test()->artisan($command, $parameters);
}

expect()->extend('toBeSentToCeliSearch', function (array $callbacks) {
    foreach ($callbacks as $callback) {
        Http::assertSent($callback);
    }

    return $this;
});

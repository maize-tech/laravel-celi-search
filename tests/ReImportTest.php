<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Maize\CeliSearch\Commands\ReImportCommand;
use Maize\CeliSearch\Tests\Support\Models\Article;
use Maize\CeliSearch\Tests\Support\Searchables\ArticleEvenSearchable;
use Maize\CeliSearch\Tests\Support\Searchables\ArticleFirstSearchable;

beforeEach(fn () => Http::fake([
    'http://celi.test/initialize' => Http::response([
        'version' => '12345',
    ]),
    '*' => Http::response(),
]));

it('can re-import data', function (array $params, array $searchables, int $count) {
    if (! empty($searchables)) {
        config()->set('celi-search.searchables', $searchables);
    }

    $articles = Article::withoutEvents(
        fn () => Article::factory()->count(5)->create()
    );

    artisan(ReImportCommand::class, $params);

    Http::assertSent(function (Request $request) {
        return expect($request->url())->toBeIn([
            'http://celi.test/initialize',
            'http://celi.test/finalize',
            'http://celi.test/data',
        ]);
    });
    Http::assertSent(function (Request $request) use ($count) {
        return expect($request['data'] ?? null)
            ->when(
                $request->url() === 'http://celi.test/data',
                fn ($data) => $data->toHaveCount($count)
            );
    });
})->with([
    [
        'params' => [
            'model' => Article::class,
        ],
        'searchables' => [],
        'count' => 5,
    ],
    [
        'params' => [],
        'searchables' => [
            Article::class,
        ],
        'count' => 5,
    ],
    [
        'params' => [],
        'searchables' => [
            ArticleEvenSearchable::class,
        ],
        'count' => 2,
    ],
    [
        'params' => [],
        'searchables' => [
            ArticleFirstSearchable::class,
        ],
        'count' => 1,
    ],
]);

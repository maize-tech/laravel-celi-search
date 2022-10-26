<?php

use Illuminate\Support\Facades\Http;
use Maize\CeliSearch\Tests\Support\Models\Article;

beforeEach(fn () => Http::fake());

it('can build a query', function (bool $highlight, array $params) {
    $articles = Article::search('test')
        ->withHighlight($highlight)
        ->withDefType($params['defType'])
        ->withMinimumShouldMatch()
        ->where('test', $params['fq'])
        ->paginate();

    expect($articles)->toBeSentToCeliSearch([
        fn ($request) => data_get($request->data(), 'q') === 'test',
        fn ($request) => data_get($request->data(), 'fq') === 'test:'.$params['fq'],
        fn ($request) => data_get($request->data(), 'hl') === $params['hl'],
        fn ($request) => data_get($request->data(), 'defType') === $params['defType'],
    ]);
})->with([
    [
        'highlight' => false,
        'params' => [
            'hl' => 'false',
            'defType' => 'dismax',
            'fq' => 'test',
        ],
    ],
    [
        'highlight' => true,
        'params' => [
            'hl' => 'true',
            'defType' => 'dismax',
            'fq' => 1,
        ],
    ],
    [
        'highlight' => true,
        'params' => [
            'hl' => 'true',
            'defType' => null,
            'fq' => null,
        ],
    ],
]);

<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Maize\CeliSearch\CeliSearch;
use Maize\CeliSearch\CeliSearchQueryBuilder;

beforeEach(fn () => Http::fake());

it('can call search api', function (?string $query, string $q) {
    expect(CeliSearch::search(
        new CeliSearchQueryBuilder($query)
    ))->toBeSentToCeliSearch([
        fn (Request $request) => $request['q'] === $q,
    ]);
})->with([
    ['query' => 'query', 'q' => 'query'],
    ['query' => '', 'q' => '*:*'],
    ['query' => null, 'q' => '*:*'],
]);

it('can call suggest api', function (?string $query, int $limit) {
    expect(
        CeliSearch::suggest($query, $limit)
    )->toBeSentToCeliSearch([
        fn (Request $request) => $request['suggest.q'] === $query,
        fn (Request $request) => $request['suggest.count'] === $limit,
    ]);
})->with([
    ['query' => 'query', 'limit' => 10],
    ['query' => 'test', 'limit' => 5],
]);

it('can call initialize api', function () {
    expect(
        CeliSearch::initialize()
    )->toBeSentToCeliSearch([
        fn (Request $request) => $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded'),
    ]);
});

it('can call finalize api', function () {
    expect(
        CeliSearch::finalize('12345')
    )->toBeSentToCeliSearch([
        fn (Request $request) => $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded'),
        fn (Request $request) => $request['version'] === '12345',
    ]);
});

it('can call create api', function (?string $version) {
    expect(
        CeliSearch::create('source', ['test' => 'test'], $version)
    )->toBeSentToCeliSearch([
        fn (Request $request) => $request->hasHeader('Content-Type', 'application/json'),
        fn (Request $request) => $request['source'] === 'source',
        fn (Request $request) => data_get($request, 'data.test') === 'test',
        fn (Request $request) => data_get($request, 'version') === $version,
    ]);
})->with([
    ['version' => '12345'],
    ['version' => null],
]);

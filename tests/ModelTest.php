<?php

use Illuminate\Support\Facades\Http;
use Maize\CeliSearch\Tests\Support\Models\Article;

beforeEach(fn () => Http::fake());

it('can create model', function () {
    $article = Article::factory()->create();

    expect(
        collect($article)
    )->toBeSentToCeliSearch([
        fn ($request) => data_get($request->data(), 'projectId') === 'test',
        fn ($request) => data_get($request->data(), 'source') === 'test_models',
        fn ($request) => data_get($request->data(), 'data.0.id') === $article->getKey(),
        fn ($request) => ! is_null(data_get($request->data(), 'data.0.updated_at')),
        fn ($request) => ! is_null(data_get($request->data(), 'data.0.created_at')),
    ]);
});

it('can update model', function () {
    $article = Article::withoutEvents(
        fn () => Article::factory()->create()
    );

    $article->touch();

    expect(
        collect($article)
    )->toBeSentToCeliSearch([
        fn ($request) => data_get($request->data(), 'projectId') === 'test',
        fn ($request) => data_get($request->data(), 'source') === 'test_models',
        fn ($request) => data_get($request->data(), 'data.0.id') === $article->getKey(),
        fn ($request) => ! is_null(data_get($request->data(), 'data.0.updated_at')),
        fn ($request) => ! is_null(data_get($request->data(), 'data.0.created_at')),
    ]);
});

it('can delete model', function () {
    $article = Article::withoutEvents(
        fn () => Article::factory()->create()
    );

    $article->delete();

    expect(
        collect($article)
    )->toBeSentToCeliSearch([
        fn ($request) => data_get($request->data(), 'projectId') === 'test',
        fn ($request) => data_get($request->data(), 'source') === 'test_models',
        fn ($request) => is_null(data_get($request->data(), 'data.0.id')),
    ]);
});

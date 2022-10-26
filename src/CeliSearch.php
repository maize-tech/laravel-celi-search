<?php

namespace Maize\CeliSearch;

use Illuminate\Support\Collection;
use Maize\CeliSearch\Support\Http\Create;
use Maize\CeliSearch\Support\Http\Destroy;
use Maize\CeliSearch\Support\Http\Finalize;
use Maize\CeliSearch\Support\Http\Initialize;
use Maize\CeliSearch\Support\Http\Search;
use Maize\CeliSearch\Support\Http\Suggest;
use Maize\CeliSearch\Support\Http\Update;

class CeliSearch
{
    public static function search(CeliSearchQueryBuilder $builder): Collection
    {
        return app(Search::class)($builder);
    }

    public static function suggest(string $query, int $limit): Collection
    {
        return app(Suggest::class)($query, $limit);
    }

    public static function initialize(): Collection
    {
        return app(Initialize::class)();
    }

    public static function finalize(string $version): Collection
    {
        return app(Finalize::class)(
            $version
        );
    }

    public static function create(string $source, array $data, ?string $version = null): Collection
    {
        return app(Create::class)(
            $source,
            $data,
            $version
        );
    }

    public static function update(string $source, array $data, ?string $version = null): Collection
    {
        return app(Update::class)(
            $source,
            $data,
            $version
        );
    }

    public static function destroy(string $source, array $data): Collection
    {
        return app(Destroy::class)(
            $source,
            $data
        );
    }
}

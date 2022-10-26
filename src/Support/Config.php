<?php

namespace Maize\CeliSearch\Support;

use Illuminate\Support\Collection;

class Config
{
    public static function getProject(): string
    {
        return config('celi-search.project');
    }

    public static function getBaseUrl(): string
    {
        return config('celi-search.base_url');
    }

    public static function getSearchBaseUrl(): string
    {
        return config('celi-search.search_base_url');
    }

    public static function getSearchables(?string $model): Collection
    {
        return collect(
            $model ?? config('celi-search.searchables')
        );
    }

    public static function getVersion(): ?string
    {
        return config('celi-search.version');
    }

    public static function setVersion(?string $version = null): void
    {
        config()->set('celi-search.version', $version);
    }

    public static function clearVersion(): void
    {
        static::setVersion();
    }
}

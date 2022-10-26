<?php

namespace Maize\CeliSearch\Support\Http;

use Maize\CeliSearch\Support\Config;

abstract class SolrRequest extends Http
{
    protected function baseUrl(): string
    {
        return Config::getSearchBaseUrl();
    }
}

<?php

namespace Maize\CeliSearch\Support\Http;

use Maize\CeliSearch\Support\Config;

abstract class BackofficeRequest extends Http
{
    protected function baseUrl(): string
    {
        return Config::getBaseUrl();
    }
}

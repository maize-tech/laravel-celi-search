<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as LaravelHttp;
use Illuminate\Support\Str;
use Maize\CeliSearch\Support\Config;

abstract class Http
{
    abstract protected function baseUrl(): string;

    protected function send(array $options = []): Response
    {
        return LaravelHttp::send(
            $this->getMethod(),
            $this->endpoint(),
            $options
        );
    }

    protected function project(): string
    {
        return Config::getProject();
    }

    protected function route(): string
    {
        return '';
    }

    protected function getMethod(): string
    {
        return defined('static::METHOD')
            /** @phpstan-ignore-next-line */
            ? static::METHOD
            : 'post';
    }

    private function endpoint(): string
    {
        $url = rtrim($this->baseUrl(), '/');
        $route = ltrim($this->route(), '/');

        return Str::of($url)->finish('/')->append($route)->__toString();
    }
}

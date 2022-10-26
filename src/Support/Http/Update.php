<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Support\Collection;

class Update extends BackofficeRequest
{
    public const METHOD = 'POST';

    public function __invoke(string $source, array $data, ?string $version = null): Collection
    {
        $version = $version ? compact('version') : [];

        $response = $this
            ->send([
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => array_merge([
                    'projectId' => $this->project(),
                    'source' => $source,
                    'data' => $data,
                ], $version),
            ])
            ->json();

        return Collection::make($response);
    }

    protected function route(): string
    {
        return 'data';
    }
}

<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Support\Collection;

class Destroy extends BackofficeRequest
{
    public const METHOD = 'DELETE';

    public function __invoke(string $source, array $data): Collection
    {
        $response = $this
            ->send([
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'projectId' => $this->project(),
                    'source' => $source,
                    'data' => $data,
                ],
            ])
            ->json();

        return Collection::make($response);
    }

    protected function route(): string
    {
        return 'data';
    }
}

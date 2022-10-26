<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Support\Collection;

class Finalize extends BackofficeRequest
{
    public const METHOD = 'POST';

    public function __invoke(string $version): Collection
    {
        $response = $this
            ->send([
                'form_params' => [
                    'projectId' => $this->project(),
                    'version' => $version,
                ],
            ])
            ->json();

        return Collection::make($response);
    }

    protected function route(): string
    {
        return 'finalize';
    }
}

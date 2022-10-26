<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Support\Collection;

class Initialize extends BackofficeRequest
{
    public const METHOD = 'PUT';

    public function __invoke(): Collection
    {
        $response = $this
            ->send([
                'form_params' => [
                    'projectId' => $this->project(),
                ],
            ])
            ->json();

        return Collection::make($response);
    }

    protected function route(): string
    {
        return 'initialize';
    }
}

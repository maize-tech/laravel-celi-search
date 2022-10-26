<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Support\Collection;

class Suggest extends SolrRequest
{
    public const METHOD = 'GET';

    public function __invoke(string $query, int $limit): Collection
    {
        $response = $this
            ->send([
                'query' => [
                    'suggest.q' => $query,
                    'suggest.count' => $limit,
                ],
            ])
            ->json();

        return Collection::make($response);
    }

    protected function route(): string
    {
        return "solr/{$this->project()}/suggest";
    }
}

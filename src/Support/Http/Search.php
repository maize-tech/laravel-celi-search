<?php

namespace Maize\CeliSearch\Support\Http;

use Illuminate\Support\Collection;
use Maize\CeliSearch\CeliSearchQueryBuilder;

class Search extends SolrRequest
{
    public const METHOD = 'GET';

    public function __invoke(CeliSearchQueryBuilder $builder): Collection
    {
        $response = $this
            ->send($builder->get())
            ->json();

        return Collection::make($response);
    }

    protected function route(): string
    {
        return "solr/{$this->project()}/select";
    }
}

<?php

namespace Maize\CeliSearch;

class CeliSearchQueryBuilder
{
    public function __construct(
        public ?string $query,
        public array $filters = [],
        public array $parameters = [],
        public ?int $start = null,
        public ?int $rows = null
    ) {
    }

    public function paginate(?int $start = null, ?int $rows = null): self
    {
        $this->start = $start;
        $this->rows = $rows;

        return $this;
    }

    public function getQuery(): string
    {
        if (empty($this->query)) {
            return '*:*';
        }

        return $this->query;
    }

    protected function getFilterQuery(): string
    {
        return collect($this->filters)
            ->map(fn ($value, $key) => "{$key}:{$value}")
            ->implode(' AND ');
    }

    public function get(): array
    {
        $query = collect([
            'q' => $this->getQuery(),
            'fq' => $this->getFilterQuery(),
            'start' => $this->start,
            'rows' => $this->rows,
        ])
            ->merge($this->parameters)
            ->filter(fn ($item) => ! is_null($item))
            ->toArray();

        return compact('query');
    }
}

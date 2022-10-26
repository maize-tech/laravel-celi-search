<?php

namespace Maize\CeliSearch;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use Maize\CeliSearch\Macros\WithHighlight;
use Maize\CeliSearch\Support\Config;

class CeliSearchEngine extends Engine
{
    protected array $parameters = [];

    public function update($models): void
    {
        $data = $models->map->toSearchableArray();

        CeliSearch::update(
            $models->first()->searchableAs(),
            $data->values()->toArray(),
            Config::getVersion()
        );
    }

    public function delete($models): void
    {
        $data = $models
            ->pluck($models->first()->getScoutKeyName())
            ->map(fn ($model) => [
                'id' => $model,
            ]);

        CeliSearch::destroy(
            $models->first()->searchableAs(),
            $data->values()->toArray()
        );
    }

    public function search(Builder $builder): Collection
    {
        return CeliSearch::search(
            $this->getCeliSearchQueryBuilder($builder)
        );
    }

    public function paginate(Builder $builder, $perPage, $page): Collection
    {
        $offset = $perPage * ($page - 1);

        return CeliSearch::search(
            $this->getCeliSearchQueryBuilder($builder)
                ->paginate($offset, $perPage)
        );
    }

    protected function getCeliSearchQueryBuilder(Builder $builder): CeliSearchQueryBuilder
    {
        return new CeliSearchQueryBuilder(
            query: $builder->query,
            filters: $builder->wheres,
            parameters: $this->parameters,
        );
    }

    public function mapIds($results): Collection
    {
        return collect(
            data_get($results, 'response.docs')
        )->pluck('id');
    }

    public function map(Builder $builder, $results, $model): Collection
    {
        $keys = $this->mapIds($results)->toArray();
        $orderKeys = array_flip($keys);

        /** @phpstan-ignore-next-line */
        return $model->getScoutModelsByIds($builder, $keys)
            ->sortBy(function ($model) use ($orderKeys) {
                return $orderKeys[$model->getScoutKey()];
            })
            ->when($this->hasHighlighting(), function ($models) use ($results) {
                return $models->each(
                    fn ($model) => $model->withScoutMetadata(
                        'highlighting',
                        data_get($results, "highlighting.{$model->searchableAs()}-{$model->getScoutKey()}")
                    )
                );
            });
    }

    public function lazyMap(Builder $builder, $results, $model): LazyCollection
    {
        return LazyCollection::make(
            $this->map($builder, $results, $model)
        );
    }

    public function getTotalCount($results): int
    {
        return data_get($results, 'response.numFound', 0);
    }

    public function flush($model): void
    {
        $data = $model::query()
            ->pluck(
                /** @phpstan-ignore-next-line */
                $model->getScoutKeyName()
            )
            ->map(fn ($model) => [
                'id' => $model,
            ]);

        CeliSearch::destroy(
            /** @phpstan-ignore-next-line */
            $model->searchableAs(),
            $data->toArray()
        );
    }

    /**
     * @throws Exception
     */
    public function createIndex($name, array $options = [])
    {
        throw new Exception('This operation is not supported.');
    }

    /**
     * @throws Exception
     */
    public function deleteIndex($name)
    {
        throw new Exception('This operation is not supported.');
    }

    public function withParameter(string $key, mixed $value): self
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function getParameter(string $key): mixed
    {
        return data_get($this->parameters, $key);
    }

    protected function hasHighlighting(): bool
    {
        return $this->getParameter(WithHighlight::KEY_NAME) === 'true';
    }
}

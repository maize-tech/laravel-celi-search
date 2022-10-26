<?php

namespace Maize\CeliSearch;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Laravel\Scout\Searchable as SearchableTrait;

abstract class Searchable
{
    abstract protected function query(): Builder;

    public function searchable($chunk = null): void
    {
        $model = $this->query()->getModel();

        $this->usesSearchableTrait($model);

        $softDelete = $this->usesSoftDelete($model);

        /** @phpstan-ignore-next-line */
        $this
            ->query()
            ->when(true, function ($query) use ($model) {
                $this->makeAllSearchableUsing($model, $query);
            })
            ->when($softDelete, function ($query) {
                /** @phpstan-ignore-next-line */
                $query->withTrashed();
            })
            ->orderBy($model->getKeyName())
            ->searchable($chunk);
    }

    public function makeAllSearchableUsing(Model $model, Builder $query): void
    {
        /** @phpstan-ignore-next-line */
        invade($model)->makeAllSearchableUsing($query);
    }

    protected function usesSoftDelete(Model $model): bool
    {
        /** @phpstan-ignore-next-line */
        if (! invade($model)->usesSoftDelete()) {
            return false;
        }

        if (! config('scout.soft_delete', false)) {
            return false;
        }

        return true;
    }

    protected function usesSearchableTrait(Model $model): void
    {
        $traits = class_uses_recursive($model);

        if (! in_array(SearchableTrait::class, $traits)) {
            throw new InvalidArgumentException();
        }
    }
}

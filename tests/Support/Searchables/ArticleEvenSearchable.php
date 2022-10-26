<?php

namespace Maize\CeliSearch\Tests\Support\Searchables;

use Illuminate\Database\Eloquent\Builder;
use Maize\CeliSearch\Searchable;
use Maize\CeliSearch\Tests\Support\Models\Article;

class ArticleEvenSearchable extends Searchable
{
    protected function query(): Builder
    {
        return Article::whereRaw('id % 2 = 0');
    }
}

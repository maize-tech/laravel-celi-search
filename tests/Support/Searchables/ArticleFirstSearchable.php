<?php

namespace Maize\CeliSearch\Tests\Support\Searchables;

use Illuminate\Database\Eloquent\Builder;
use Maize\CeliSearch\Searchable;
use Maize\CeliSearch\Tests\Support\Models\Article;

class ArticleFirstSearchable extends Searchable
{
    protected function query(): Builder
    {
        return Article::whereKey(1);
    }
}

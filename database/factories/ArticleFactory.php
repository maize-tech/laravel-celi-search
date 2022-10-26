<?php

namespace Maize\CeliSearch\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Maize\CeliSearch\Tests\Support\Models\Article;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [];
    }
}

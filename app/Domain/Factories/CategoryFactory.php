<?php

namespace LaravelItalia\Domain\Factories;

use Illuminate\Support\Str;
use LaravelItalia\Domain\Category;

/**
 * Class CategoryFactory.
 */
class CategoryFactory
{
    /**
     * @param $name
     *
     * @return Category
     */
    public static function createCategory($name)
    {
        $category = new Category();

        $category->name = $name;
        $category->slug = Str::slug($category->name);

        return $category;
    }
}

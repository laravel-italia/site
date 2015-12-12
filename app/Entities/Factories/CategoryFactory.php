<?php

namespace LaravelItalia\Entities\Factories;

use Illuminate\Support\Str;
use LaravelItalia\Entities\Category;

/**
 * Class CategoryFactory.
 */
class CategoryFactory
{
    /**
     * Creates a new Category instance, starting from the name.
     *
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

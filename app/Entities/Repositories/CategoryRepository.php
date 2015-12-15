<?php

namespace LaravelItalia\Entities\Repositories;

use LaravelItalia\Entities\Category;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;

/**
 * Class CategoryRepository.
 */
class CategoryRepository
{
    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new NotSavedException();
        }
    }

    public function findById($id)
    {
        $category = Category::find($id);

        if (!$category) {
            throw new NotFoundException();
        }

        return $category;
    }

    public function findBySlug($slug)
    {
        $category = Category::where('slug', '=', $slug)->first();

        if (!$category) {
            throw new NotFoundException();
        }

        return $category;
    }

    public function getAll()
    {
        return Category::all();
    }

    public function delete(Category $category)
    {
        if (!$category->delete()) {
            throw new NotDeletedException();
        }
    }
}

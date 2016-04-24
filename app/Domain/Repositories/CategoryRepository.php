<?php

namespace LaravelItalia\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Domain\Category;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

/**
 * Class CategoryRepository.
 */
class CategoryRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Category::all();
    }

    /**
     * @param array $ids
     *
     * @return Collection|static[]
     */
    public function getByIds(array $ids)
    {
        return Category::findMany($ids);
    }

    /**
     * @param $id
     *
     * @return Category|null
     *
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $category = Category::find($id);

        if (!$category) {
            throw new NotFoundException();
        }

        return $category;
    }

    /**
     * @param $slug
     *
     * @return Category|null
     *
     * @throws NotFoundException
     */
    public function findBySlug($slug)
    {
        $category = Category::where('slug', '=', $slug)->first();

        if (!$category) {
            throw new NotFoundException();
        }

        return $category;
    }

    /**
     * @param Category $category
     *
     * @throws NotSavedException
     */
    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new NotSavedException();
        }
    }

    /**
     * @param Category $category
     *
     * @throws NotDeletedException
     * @throws \Exception
     */
    public function delete(Category $category)
    {
        if (!$category->delete()) {
            throw new NotDeletedException();
        }
    }
}

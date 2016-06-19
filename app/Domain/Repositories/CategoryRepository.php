<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Category;
use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

class CategoryRepository
{
    /**
     * Restituisce le categorie salvate sul database.
     *
     * @return Collection|static[]
     */
    public function getAll()
    {
        return Category::all();
    }

    /**
     * Restituisce un set di categorie a partire dai loro id.
     *
     * @param array $ids
     * @return mixed
     */
    public function getByIds(array $ids)
    {
        return Category::findMany($ids);
    }

    /**
     * Restituisce una categoria a partire dal suo id.
     *
     * @param $id
     * @return mixed
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
     * Restituisce una categoria a partire dal suo slug.
     *
     * @param $slug
     * @return mixed
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
     * Salva una categoria $category su database.
     *
     * @param Category $category
     * @throws NotSavedException
     */
    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new NotSavedException();
        }
    }

    /**
     * Rimuove dal database la categoria $category.
     *
     * @param Category $category
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

<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Category;

/**
 * Class CategoryObserver.
 */
class CategoryObserver
{
    /**
     * @param Category $category
     */
    public function deleting(Category $category)
    {
        $category->articles()->detach();
    }
}

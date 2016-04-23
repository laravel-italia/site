<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Category;

/**
 * Class DetachArticlesWhenDeletingCategory.
 */
class DetachArticlesWhenDeletingCategory
{
    /**
     * @param Category $category
     */
    public function deleting(Category $category)
    {
        $category->articles()->detach();
    }
}

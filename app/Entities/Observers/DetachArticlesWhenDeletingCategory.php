<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Category;

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

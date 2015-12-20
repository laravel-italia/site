<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Category;

/**
 * Class CategoryObserver
 * @package LaravelItalia\Entities\Observers
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

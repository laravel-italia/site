<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Category;

class CategoryObserver
{
    public function deleting(Category $category)
    {
        $category->articles()->detach();
    }
}

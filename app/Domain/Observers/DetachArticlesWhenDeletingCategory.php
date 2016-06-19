<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Category;

/**
 * Data una categoria che sta per essere cancellata, ne viene rimossa ogni associazione con gli articoli
 * ad essa correlati.
 *
 * Class DetachArticlesWhenDeletingCategory
 * @package LaravelItalia\Domain\Observers
 */
class DetachArticlesWhenDeletingCategory
{
    public function deleting(Category $category)
    {
        $category->articles()->detach();
    }
}

<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Article;

/**
 * Class DetachCategoriesBeforeArticleDelete.
 */
class DetachCategoriesBeforeArticleDelete
{
    /**
     * @param Article $article
     */
    public function deleting(Article $article)
    {
        $article->categories()->detach();
    }
}

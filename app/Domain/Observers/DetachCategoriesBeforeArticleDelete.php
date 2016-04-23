<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Article;

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

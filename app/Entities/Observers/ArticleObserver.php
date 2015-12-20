<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Article;

/**
 * Class ArticleObserver.
 */
class ArticleObserver
{
    /**
     * @param Article $article
     */
    public function deleting(Article $article)
    {
        $article->categories()->detach();
    }
}

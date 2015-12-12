<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Article;

class ArticleObserver
{
    public function deleting(Article $article)
    {
        $article->categories()->detach();
    }
}

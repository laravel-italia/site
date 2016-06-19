<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Article;

/**
 * Dato un articolo che sta per essere cancellato, si occupa di rimuovere le associazioni alle categorie relative.
 *
 * Class DetachCategoriesBeforeArticleDelete
 * @package LaravelItalia\Domain\Observers
 */
class DetachCategoriesBeforeArticleDelete
{
    public function deleting(Article $article)
    {
        $article->categories()->detach();
    }
}

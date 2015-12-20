<?php

namespace LaravelItalia\Entities\Factories;

use Illuminate\Support\Str;
use LaravelItalia\Entities\Article;

/**
 * Class ArticleFactory
 * @package LaravelItalia\Entities\Factories
 */
class ArticleFactory
{
    /**
     * @param $title
     * @param $digest
     * @param $body
     * @param $metaDescription
     * @return Article
     */
    public static function createArticle($title, $digest, $body, $metaDescription)
    {
        $article = new Article();

        $article->title = $title;
        $article->slug = Str::slug($title);

        $article->digest = $digest;
        $article->body = $body;

        $article->metadescription = $metaDescription;

        $article->published_at = null;

        return $article;
    }
}

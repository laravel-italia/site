<?php

namespace LaravelItalia\Entities\Factories;


use Illuminate\Support\Str;
use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\User;

/**
 * Class ArticleFactory
 * @package LaravelItalia\Entities\Factories
 */
class ArticleFactory
{
    /**
     * Creates a new Article instance, starting from the title, digest, body
     * and metadescription, for a certain User.
     *
     * @param User $user
     * @param $title
     * @param $digest
     * @param $body
     * @param $metaDescription
     *
     * @return Article
     */
    public static function createArticleForUser(User $user, $title, $digest, $body, $metaDescription)
    {
        $article = new Article;

        $article->title = $title;
        $article->slug = Str::slug($title);

        $article->digest = $digest;
        $article->body = $body;

        $article->metadescription = $metaDescription;

        $article->is_published = false;
        $article->published_at = null;

        $article->user()->associate($user);

        return $article;
    }
}
<?php

use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\Factories\ArticleFactory;

class ArticleFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a new Article in the right way.
     */
    public function testCanCreateArticle()
    {
        $article = ArticleFactory::createArticle(
            'Article Title',
            'Digest here...',
            'Body...',
            'Metadescription...'
        );

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('Article Title', $article->title);
        $this->assertEquals('article-title', $article->slug);
        $this->assertNull($article->published_at);
    }
}

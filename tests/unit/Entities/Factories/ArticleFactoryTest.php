<?php

use LaravelItalia\Entities\Factories\ArticleFactory;

class ArticleFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a new Article in the right way.
     *
     * @return void
     */
    public function testCanCreateArticle()
    {
        $userMock = $this->getMock(\LaravelItalia\Entities\User::class);

        $article = ArticleFactory::createArticleForUser(
            $userMock,
            'Article Title',
            'Digest here...',
            'Body...',
            'Metadescription...'
        );

        $this->assertEquals('Article Title', $article->title);
        $this->assertEquals('article-title', $article->slug);
        $this->assertNull($article->published_at);
    }
}

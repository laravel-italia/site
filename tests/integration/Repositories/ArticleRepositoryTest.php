<?php

use LaravelItalia\Entities\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\ArticleRepository;

class ArticleRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var ArticleRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new ArticleRepository();
        parent::setUp();
    }

    public function testCanGetAll()
    {
        $articles = $this->repository->getAll(1);

        $this->assertCount(0, $articles);

        $this->saveTestArticle();

        $articles = $this->repository->getAll(1);

        $this->assertCount(1, $articles);
    }

    public function testCanSave()
    {
        $this->saveTestArticle();

        $this->seeInDatabase('articles', [
            'title' => 'Test title'
        ]);
    }

    public function testCanDelete()
    {
        $article = $this->saveTestArticle();

        $this->repository->delete($article);

        $this->dontSeeInDatabase('articles', [
            'title' => 'Test title'
        ]);
    }

    public function testFindBySlug()
    {
        $expectedArticle = $this->saveTestArticle();

        $article = $this->repository->findBySlug($expectedArticle->slug);

        $this->assertEquals($expectedArticle->id, $article->id);
    }

    public function testFindById()
    {
        $expectedArticle = $this->saveTestArticle();

        $article = $this->repository->findById($expectedArticle->id);

        $this->assertEquals($expectedArticle->id, $article->id);
    }

    public function prepareTestArticle()
    {
        $article = new Article;

        $article->title = 'Test title';
        $article->slug = \Illuminate\Support\Str::slug($article->title);

        $article->digest = 'digest test...';
        $article->body = 'body test...';

        $article->metadescription = '...';

        $article->published_at = null;

        $article->user_id = 1;

        return $article;
    }

    public function saveTestArticle()
    {
        $article = $this->prepareTestArticle();
        $article->save();

        return $article;
    }
}
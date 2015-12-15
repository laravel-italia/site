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
        $this->saveTestArticle(true);

        $this->assertCount(2, $this->repository->getAll(1));
        $this->assertCount(1, $this->repository->getAll(1, true));
    }

    public function testCanSave()
    {
        $this->saveTestArticle();

        $this->seeInDatabase('articles', [
            'title' => 'Test title',
        ]);
    }

    public function testCanDelete()
    {
        $article = $this->saveTestArticle();

        $this->repository->delete($article);

        $this->dontSeeInDatabase('articles', [
            'title' => 'Test title',
        ]);
    }

    public function testFindBySlugIsOk()
    {
        $expectedArticle = $this->saveTestArticle();

        $article = $this->repository->findBySlug($expectedArticle->slug);

        $this->assertEquals($expectedArticle->id, $article->id);
    }

    /**
     * @expectedException           LaravelItalia\Exceptions\NotFoundException
     */
    public function testFindBySlugThrowExceptionIfNotFound()
    {
        $this->repository->findBySlug('i_dont_exist_lol');
    }

    public function testFindByIdIsOk()
    {
        $expectedArticle = $this->saveTestArticle();

        $article = $this->repository->findById($expectedArticle->id);

        $this->assertEquals($expectedArticle->id, $article->id);
    }

    /**
     * @expectedException           LaravelItalia\Exceptions\NotFoundException
     */
    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->repository->findById(999);
    }

    public function prepareTestArticle($published = false)
    {
        $article = new Article();

        $article->title = 'Test title';
        $article->slug = \Illuminate\Support\Str::slug($article->title);

        $article->digest = 'digest test...';
        $article->body = 'body test...';

        $article->metadescription = '...';

        if ($published) {
            $article->publish(\Carbon\Carbon::now());
        } else {
            $article->unpublish();
        }

        $article->user_id = 1;

        return $article;
    }

    public function saveTestArticle($published = false)
    {
        $article = $this->prepareTestArticle($published);
        $article->save();

        return $article;
    }
}

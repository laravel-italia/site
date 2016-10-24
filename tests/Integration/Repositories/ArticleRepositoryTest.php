<?php

namespace Tests\Integration\Repositories;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\ArticleRepository;
use Tests\Integration\Repositories\Support\EntitiesPreparer;

class ArticleRepositoryTest extends TestCase
{
    use DatabaseMigrations, EntitiesPreparer;

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
        $this->assertCount(0, $this->repository->getAll(1));

        $this->saveTestArticle();
        $this->saveTestArticle(true);
        $this->saveTestArticle(true, true);

        $this->assertCount(3, $this->repository->getAll(1));
        $this->assertCount(2, $this->repository->getAll(1, true));
        $this->assertCount(1, $this->repository->getAll(1, true, true));
    }

    public function testCanGetUnpublished()
    {
        $this->assertCount(0, $this->repository->getUnpublished());

        $this->saveTestArticle(false);
        $this->saveTestArticle(true);

        $this->assertCount(1, $this->repository->getUnpublished());
    }

    public function testGetByCategory()
    {
        $category = $this->saveTestCategory('Category');

        $this->saveTestArticle(false, false, null, $category);
        $this->saveTestArticle(true, false, null, $category);

        $this->assertCount(1, $this->repository->getByCategory($category, 1, true));
        $this->assertCount(2, $this->repository->getByCategory($category, 1, false));
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
     * @expectedException   \LaravelItalia\Exceptions\NotFoundException
     */
    public function testFindBySlugThrowExceptionIfNotFound()
    {
        $this->repository->findBySlug('i_dont_exist_lol');
    }

    public function testFindById()
    {
        $expectedArticle = $this->saveTestArticle();

        $article = $this->repository->findById($expectedArticle->id);

        $this->assertEquals($expectedArticle->id, $article->id);
    }

    /**
     * @expectedException   \LaravelItalia\Exceptions\NotFoundException
     */
    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->repository->findById(999);
    }

    public function testFindBySeriesAndSlug()
    {
        $series = $this->saveTestSeries(true);
        $expectedArticle = $this->saveTestArticle(true, true);
        $anotherArticle = $this->saveTestArticle(true, true);

        $this->assignTestSeriesToArticle($series, $expectedArticle);

        $article = $this->repository->findBySeriesAndSlug($series, 'test-title');

        $this->assertEquals($expectedArticle->id, $article->id);
        $this->assertNotEquals($anotherArticle->id, $article->id);
    }

    /**
     * @expectedException   \LaravelItalia\Exceptions\NotFoundException
     */
    public function testFindBySeriesAndSlugThrowsExceptionIfNotFound()
    {
        $series = $this->saveTestSeries(true);
        $this->saveTestArticle(true, true);

        $this->repository->findBySeriesAndSlug($series, 'test-title');
    }

    public function testGetTodayArticles()
    {
        $user = $this->saveTestUser();
        $category = $this->saveTestCategory('My Category');

        $this->saveTestArticle(true, true, $user, $category);
        $this->saveTestArticle(true, true, $user, $category);
        $this->saveTestArticle(true, false, $user, $category);

        $results = $this->repository->getTodayArticles();

        $this->assertCount(2, $results);
        $this->assertGreaterThan($results[0]->id, $results[1]->id);
    }

    public function testGetTodayArticlesWithUnpublished()
    {
        $user = $this->saveTestUser();
        $category = $this->saveTestCategory('My Category');

        $this->saveTestArticle(true, true, $user, $category);

        $nextArticle = $this->saveTestArticle(true, true, $user, $category);
        $nextArticle->publish(Carbon::now()->addHour());
        $nextArticle->save();

        $results = $this->repository->getTodayArticles(false);

        $this->assertCount(2, $results);
        $this->assertGreaterThan($results[1]->id, $results[0]->id);
    }

    public function testGetTodayArticlesNoResults()
    {
        $this->assertCount(0, $this->repository->getTodayArticles());
    }
}

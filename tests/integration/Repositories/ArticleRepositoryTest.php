<?php

use LaravelItalia\Domain\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\ArticleRepository;

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
        $this->assertCount(0, $this->repository->getAll(1));

        $this->saveTestArticle();
        $this->saveTestArticle(true);

        $this->assertCount(2, $this->repository->getAll(1));
        $this->assertCount(1, $this->repository->getAll(1, true));
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
        $category = \LaravelItalia\Domain\Category::createFromName('Category');
        $category->save();

        $this->saveTestArticle(false, null, $category);
        $this->saveTestArticle(true, null, $category);

        $this->assertCount(1, $this->repository->getByCategory($category, 1, true));
        $this->assertCount(2, $this->repository->getByCategory($category, 1, false));
    }

    public function testGetByUser()
    {
        $user = \LaravelItalia\Domain\Factories\UserFactory::createUser('Francesco', 'email', 'password');
        $user->save();

        $this->saveTestArticle(false, $user);
        $this->saveTestArticle(true, $user);

        $this->assertCount(1, $this->repository->getByUser($user, 1, true));
        $this->assertCount(2, $this->repository->getByUser($user, 1, false));
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

        return $article;
    }

    public function saveTestArticle($published = false, \LaravelItalia\Domain\User $user = null, \LaravelItalia\Domain\Category $category = null)
    {
        $article = $this->prepareTestArticle($published);

        if($user) {
            $article->setUser($user);
        }

        $article->save();

        if($category) {
            $article->syncCategories(new \Illuminate\Database\Eloquent\Collection([$category]));
        }

        return $article;
    }
}

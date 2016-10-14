<?php

namespace Tests\Integration\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\CategoryRepository;
use Tests\Integration\Repositories\Support\EntitiesPreparer;

class CategoryRepositoryTest extends TestCase
{
    use DatabaseMigrations, EntitiesPreparer;

    /**
     * @var CategoryRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new CategoryRepository();
        parent::setUp();
    }

    public function testCanSave()
    {
        $this->repository->save($this->prepareTestCategory('Test Category'));

        $this->seeInDatabase('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    public function testCanFindById()
    {
        $expectedCategory = $this->saveTestCategory();

        $existingCategory = $this->repository->findById($expectedCategory->id);

        $this->assertNotNull($existingCategory);
    }

    /**
     * @expectedException   \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByIdThrowsException()
    {
        $this->repository->findById(999);
    }

    public function testCanFindBySlug()
    {
        $this->saveTestCategory();

        $existingCategory = $this->repository->findBySlug('test-category');

        $this->assertNotNull($existingCategory);
    }

    /**
     * @expectedException   \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindBySlugThrowsException()
    {
        $this->repository->findBySlug('test-category');
    }

    public function testCanGetAll()
    {
        $this->assertEmpty($this->repository->getAll());

        $this->saveTestCategory();

        $this->assertCount(1, $this->repository->getAll());
    }

    public function testGetByIds()
    {
        $cat1 = $this->saveTestCategory('Test Category');
        $cat2 = $this->saveTestCategory('Test Category 2');

        $this->assertCount(0, $this->repository->getByIds([99]));
        $this->assertCount(1, $this->repository->getByIds([$cat1->id, 99]));
        $this->assertCount(2, $this->repository->getByIds([$cat1->id, $cat2->id]));
    }

    public function testCanDelete()
    {
        $category = $this->saveTestCategory();

        $this->repository->delete($category);

        $this->dontSeeInDatabase('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }
}

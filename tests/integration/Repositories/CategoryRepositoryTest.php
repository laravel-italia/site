<?php

use LaravelItalia\Domain\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\CategoryRepository;

class CategoryRepositoryTest extends TestCase
{
    use DatabaseMigrations;

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
        $this->repository->save($this->prepareTestCategory());

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
     * @expectedException           LaravelItalia\Exceptions\NotFoundException
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
     * @expectedException           LaravelItalia\Exceptions\NotFoundException
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

    public function testCanDelete()
    {
        $category = $this->saveTestCategory();

        $this->repository->delete($category);

        $this->dontSeeInDatabase('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    private function prepareTestCategory()
    {
        $category = new Category();

        $category->name = 'Test Category';
        $category->slug = 'test-category';

        return $category;
    }

    private function saveTestCategory()
    {
        $testCategory = $this->prepareTestCategory();
        $testCategory->save();

        return $testCategory;
    }
}

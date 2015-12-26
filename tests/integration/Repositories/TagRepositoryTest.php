<?php

use LaravelItalia\Entities\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\TagRepository;

class TagRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var TagRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new TagRepository();
        parent::setUp();
    }

    public function testCanSave()
    {
        $this->repository->save($this->prepareTestTag('Test'));

        $this->seeInDatabase('tags', [
            'name' => 'Test',
            'slug' => 'test',
        ]);
    }

    public function testCanFindById()
    {
        $expectedTag = $this->saveTestTag('Test');

        $existingTag = $this->repository->findById($expectedTag->id);

        $this->assertNotNull($existingTag);
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
        $this->saveTestTag('Test');

        $existingCategory = $this->repository->findBySlug('test');

        $this->assertNotNull($existingCategory);
    }

    /**
     * @expectedException           LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindBySlugThrowsException()
    {
        $this->repository->findBySlug('not-existing-tag');
    }

    public function testCanGetAll()
    {
        $this->assertEmpty($this->repository->getAll());

        $this->saveTestTag('Test');

        $this->assertCount(1, $this->repository->getAll());
    }

    public function testCanGetBySlugs()
    {
        $this->saveTestTag('Test1');
        $this->saveTestTag('Test2');

        $this->assertCount(0, $this->repository->getBySlugs([]));
        $this->assertCount(0, $this->repository->getBySlugs(['tag1', 'tag2']));
        $this->assertCount(1, $this->repository->getBySlugs(['test1']));
        $this->assertCount(2, $this->repository->getBySlugs(['test1', 'test2']));
    }

    public function testCanDelete()
    {
        $tag = $this->saveTestTag('Test');

        $this->seeInDatabase('tags', [
            'name' => 'Test',
        ]);

        $this->repository->delete($tag);

        $this->dontSeeInDatabase('tags', [
            'name' => 'Test',
        ]);
    }

    private function prepareTestTag($tagName)
    {
        $tag = new Tag();

        $tag->name = $tagName;
        $tag->slug = \Illuminate\Support\Str::slug($tagName);

        return $tag;
    }

    private function saveTestTag($tagName)
    {
        $testTag = $this->prepareTestTag($tagName);
        $testTag->save();

        return $testTag;
    }
}

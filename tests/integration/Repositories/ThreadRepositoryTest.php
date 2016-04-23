<?php

use LaravelItalia\Domain\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\ThreadRepository;

class ThreadRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /* @var ThreadRepository */
    private $repository;

    public function setUp()
    {
        $this->repository = new ThreadRepository();
        parent::setUp();
    }

    public function testCanGetAll()
    {
        $this->assertCount(0, $this->repository->getAll(1));

        $this->saveTestThread('Test 123', []);

        $this->assertCount(1, $this->repository->getAll(1));
    }


    public function testCanGetByTags()
    {
        $this->markTestSkipped('Locally works, not on Travis. Check it when possible.');

        $this->saveTestThread('Thread 1', ['tag1', 'tag2']);
        $this->saveTestThread('Thread 2', ['tag3']);
        $this->saveTestThread('Thread 3', ['tag1', 'tag3', 'tag5']);
        $this->getOrCreateTestTag('tag4');

        $this->assertCount(0, $this->repository->getByTags(new \Illuminate\Database\Eloquent\Collection(), 1));
        $this->assertCount(0, $this->repository->getByTags(\LaravelItalia\Domain\Tag::where('name', 'tag4')->get(), 1));
        $this->assertCount(1, $this->repository->getByTags(\LaravelItalia\Domain\Tag::where('name', 'tag2')->get(), 1));
        $this->assertCount(2, $this->repository->getByTags(\LaravelItalia\Domain\Tag::where('name', 'tag1')->orWhere('name', 'tag5')->get(), 1));
        $this->assertCount(3, $this->repository->getByTags(\LaravelItalia\Domain\Tag::all(), 1));
    }

    public function testCanSave()
    {
        $thread = $this->prepareTestThread('Title');

        $this->repository->save($thread);

        $this->seeInDatabase('threads', [
            'title' => 'Title',
        ]);
    }

    public function testCanDelete()
    {
        $thread = $this->saveTestThread('Title', []);

        $this->seeInDatabase('threads', [
            'title' => 'Title',
        ]);

        $this->repository->delete($thread);

        $this->dontSeeInDatabase('threads', [
            'title' => 'Title',
        ]);
    }

    private function saveTestThread($title, array $associatedTags)
    {
        $thread = $this->prepareTestThread($title);

        $thread->save();

        foreach ($associatedTags as $aTag) {
            $tag = $this->getOrCreateTestTag($aTag);
            $thread->tags()->attach($tag->id);
        }

        return $thread;
    }

    private function prepareTestThread($title)
    {
        $thread = new Thread();

        $thread->title = $title;
        $thread->slug = \Illuminate\Support\Str::slug($title);
        $thread->is_closed = false;

        $thread->user_id = 1;

        return $thread;
    }

    private function getOrCreateTestTag($name)
    {
        $tag = \LaravelItalia\Domain\Tag::where('name', $name)->first();

        if (!$tag) {
            $tag = new \LaravelItalia\Domain\Tag();
            $tag->name = $name;
            $tag->slug = str_slug($name);
            $tag->save();
        }

        return $tag;
    }
}

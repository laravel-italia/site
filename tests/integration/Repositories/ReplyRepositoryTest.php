<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\ReplyRepository;
use LaravelItalia\Entities\Thread;
use LaravelItalia\Entities\Reply;

class ReplyRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /* @var ReplyRepository */
    private $repository;

    public function setUp()
    {
        $this->repository = new ReplyRepository();
        parent::setUp();
    }

    public function testCanGetByThread()
    {
        $thread1 = $this->saveTestThread('Thread 1');
        $thread2 = $this->saveTestThread('Thread 2');

        $thread1->replies()->save(
            $this->prepareTestReply('Hey there! Message for thread 1...')
        );

        $thread1->replies()->save(
            $this->prepareTestReply('Yo! Nice to see you here!')
        );

        $thread2->replies()->save(
            $this->prepareTestReply('Forever alone...')
        );

        $this->assertCount(2, $this->repository->getByThread($thread1, 1));
        $this->assertCount(1, $this->repository->getByThread($thread2, 1));
    }

    public function testCanSave()
    {
        $reply = $this->prepareTestReply('This is a test reply...');
        $reply->user_id = 1;

        $this->repository->save($reply);

        $this->seeInDatabase('replies', [
            'body' => 'This is a test reply...',
            'user_id' => 1
        ]);
    }

    public function testCanDelete()
    {
        $reply = $this->saveTestReply('This is a test reply...');

        $this->seeInDatabase('replies', [
            'body' => 'This is a test reply...',
            'user_id' => 1
        ]);

        $this->repository->delete($reply);

        $this->dontSeeInDatabase('replies', [
            'body' => 'This is a test reply...',
            'user_id' => 1
        ]);
    }

    private function prepareTestReply($body)
    {
        $reply = new Reply();
        $reply->body = $body;
        $reply->user_id = 1;

        return $reply;
    }

    private function saveTestReply($body)
    {
        $reply = $this->prepareTestReply($body);
        $reply->user_id = 1;
        $reply->save();

        return $reply;
    }

    private function saveTestThread($title)
    {
        $thread = new Thread();

        $thread->title = $title;
        $thread->slug = \Illuminate\Support\Str::slug($title);
        $thread->is_closed = false;

        $thread->user_id = 1;
        $thread->save();

        return $thread;
    }
}

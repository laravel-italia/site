<?php

use LaravelItalia\Domain\Thread;
use LaravelItalia\Domain\Factories\ThreadFactory;

class ThreadFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Thread in the right way.
     */
    public function testCanCreateThread()
    {
        $thread = ThreadFactory::createThread('Test Thread', 'Lorem ipsum body...');

        $this->assertInstanceOf(Thread::class, $thread);
        $this->assertEquals('Test Thread', $thread->title);
        $this->assertEquals(time().'-test-thread', $thread->slug);
        $this->assertEquals('Lorem ipsum body...', $thread->body);
        $this->assertFalse($thread->is_closed);
    }
}

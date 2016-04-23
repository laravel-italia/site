<?php

use LaravelItalia\Domain\Reply;
use LaravelItalia\Domain\Factories\ReplyFactory;

class ReplyFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Reply in the right way.
     */
    public function testCanCreateReply()
    {
        $reply = ReplyFactory::createReply('Lorem ipsum body...');

        $this->assertInstanceOf(Reply::class, $reply);
        $this->assertEquals('Lorem ipsum body...', $reply->body);
    }
}

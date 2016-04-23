<?php

use LaravelItalia\Domain\Tag;
use LaravelItalia\Domain\Factories\TagFactory;

class TagFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Tag in the right way.
     */
    public function testCanCreateCategory()
    {
        $tag = TagFactory::createTag('Test');

        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertEquals('Test', $tag->name);
        $this->assertEquals('test', $tag->slug);
    }
}
